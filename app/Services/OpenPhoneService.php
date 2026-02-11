<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenPhoneService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openphone.key');
        $this->baseUrl = config('services.openphone.base_url');
    }

    /**
     * Test API connection
     * 
     * @return array
     */
    public function testConnection()
    {
        if (empty($this->apiKey)) {
            throw new \Exception('OpenPhone API key is not configured');
        }

        try {
            // Test with a simple API call (e.g., get phone numbers)
            // OpenPhone uses: Authorization: YOUR_API_KEY (not Bearer)
            $response = Http::withHeaders([
                    'Authorization' => $this->apiKey,
                ])
                ->withoutVerifying() // Bypass SSL verification for development
                ->get("{$this->baseUrl}/phone-numbers");

            if ($response->successful()) {
                return [
                    'connected' => true,
                    'api_key_valid' => true,
                    'response_code' => $response->status(),
                    'data' => $response->json(),
                ];
            }

            throw new \Exception('API returned status: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('OpenPhone API connection test failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch calls from OpenPhone using a generator for better performance and pagination.
     * 
     * @param string|null $date Date in Y-m-d format. Defaults to today.
     * @return \Generator
     */
    public function fetchCalls($date = null)
    {
        if (empty($this->apiKey)) {
            Log::info('OpenPhone: No API key configured, using dummy data');
            foreach ($this->getDummyData() as $dummy) {
                yield $dummy;
            }
            return;
        }

        try {
            // If a date is provided, treat it as a local date in the app timezone and convert to UTC
            if ($date) {
                $createdAfter = \Carbon\Carbon::createFromFormat('Y-m-d', $date, config('app.timezone'))
                    ->startOfDay()
                    ->utc()
                    ->toIso8601String();
            } else {
                $createdAfter = now()->startOfDay()->utc()->toIso8601String();
            }
            Log::info('OpenPhone: Starting fetch with generator after ' . $createdAfter);

            $processedParticipants = [];
            $convPageToken = null;

            // Step 1: Paginate through all conversations
            do {
                $convParams = [
                    'createdAfter' => $createdAfter,
                    'maxResults' => 100
                ];
                if ($convPageToken) {
                    $convParams['pageToken'] = $convPageToken;
                }

                $convResponse = Http::withHeaders(['Authorization' => $this->apiKey])
                    ->withoutVerifying()
                    ->get("{$this->baseUrl}/conversations", $convParams);

                if (!$convResponse->successful()) {
                    Log::error('OpenPhone: Failed to fetch conversations', [
                        'status' => $convResponse->status(),
                        'body' => $convResponse->body()
                    ]);
                    break;
                }

                $convData = $convResponse->json();
                $conversations = $convData['data'] ?? [];
                $convPageToken = $convData['nextPageToken'] ?? null;

                foreach ($conversations as $conv) {
                    $pnId = $conv['phoneNumberId'] ?? null;
                    $participants = $conv['participants'] ?? [];

                    if (!$pnId || empty($participants)) {
                        continue;
                    }

                    // Avoid duplicate processing for the same participant + PN ID in the same batch
                    $key = $pnId . '_' . implode(',', $participants);
                    if (isset($processedParticipants[$key])) {
                        continue;
                    }
                    $processedParticipants[$key] = true;

                    // Step 2: Paginate through calls for each conversation's participants
                    $callPageToken = null;
                    do {
                        $callParams = [
                            'phoneNumberId' => $pnId,
                            'participants' => $participants,
                            'createdAfter' => $createdAfter,
                            'maxResults' => 100
                        ];
                        if ($callPageToken) {
                            $callParams['pageToken'] = $callPageToken;
                        }

                        $callResponse = Http::withHeaders(['Authorization' => $this->apiKey])
                            ->withoutVerifying()
                            ->get("{$this->baseUrl}/calls", $callParams);

                        if ($callResponse->successful()) {
                            $callData = $callResponse->json();
                            $calls = $callData['data'] ?? [];
                            $callPageToken = $callData['nextPageToken'] ?? null;

                            foreach ($calls as $call) {
                                // We don't fetch recording_url here to avoid slow individual API calls
                                // The recording URL will be fetched on-demand during the import process
                                $participants_list = $call['participants'] ?? [];
                                $from = $call['direction'] === 'outgoing' ? 'TruckZap' : ($participants_list[0] ?? 'Unknown');
                                $to = $call['direction'] === 'incoming' ? 'TruckZap' : ($participants_list[1] ?? ($participants_list[0] ?? 'Unknown'));

                                yield [
                                    'id' => $call['id'],
                                    'from' => $from,
                                    'to' => $to,
                                    'direction' => $call['direction'],
                                    'duration' => $call['duration'] ?? 0,
                                    'created_at' => $call['createdAt'],
                                    'userId' => $call['userId'] ?? null,
                                    'phoneNumberId' => $pnId,
                                ];
                            }
                        } else {
                            Log::warning("OpenPhone: Failed to fetch calls for PN $pnId", [
                                'status' => $callResponse->status(),
                                'body' => $callResponse->body()
                            ]);
                            break;
                        }
                    } while ($callPageToken);
                }
            } while ($convPageToken);

        } catch (\Exception $e) {
            Log::error('OpenPhone API call failed: ' . $e->getMessage());
        }
    }

    /**
     * Fetch all users from the workspace
     */
    public function fetchUsers()
    {
        try {
            $response = Http::withHeaders(['Authorization' => $this->apiKey])
                ->withoutVerifying()
                ->get("{$this->baseUrl}/users");

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }
            return [];
        } catch (\Exception $e) {
            Log::error('OpenPhone: Failed to fetch users: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch all phone numbers/inboxes from the workspace
     */
    public function fetchPhoneNumbers()
    {
        try {
            $response = Http::withHeaders(['Authorization' => $this->apiKey])
                ->withoutVerifying()
                ->get("{$this->baseUrl}/phone-numbers");

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }
            return [];
        } catch (\Exception $e) {
            Log::error('OpenPhone: Failed to fetch phone numbers: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch recordings for a specific call
     */
    public function fetchRecordingUrl($callId)
    {
        try {
            $response = Http::withHeaders(['Authorization' => $this->apiKey])
                ->withoutVerifying()
                ->get("{$this->baseUrl}/call-recordings/{$callId}");

            if ($response->successful()) {
                $recordings = $response->json()['data'] ?? [];
                // Return the URL of the first (most recent or only) recording
                return $recordings[0]['url'] ?? null;
            }
            return null;
        } catch (\Exception $e) {
            Log::error("OpenPhone: Failed to fetch recording for call $callId: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch AI summary for a specific call
     */
    public function fetchCallSummary($callId)
    {
        try {
            $response = Http::withHeaders(['Authorization' => $this->apiKey])
                ->withoutVerifying()
                ->get("{$this->baseUrl}/call-summaries/{$callId}");

            Log::info("OpenPhone: Summary response for $callId", [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                $data = $response->json()['data'] ?? [];
                
                // The summary content might be in $data['summary']['content'], $data['content'], or $data['summary']
                $summaryContent = $data['summary']['content'] ?? $data['content'] ?? $data['summary'] ?? null;

                if (is_array($summaryContent)) {
                    // join array of strings into a single string
                    return implode("\n", array_filter($summaryContent));
                }

                if (is_string($summaryContent)) {
                    return $summaryContent;
                }
            }
            return null;
        } catch (\Exception $e) {
            Log::error("OpenPhone: Failed to fetch summary for call $callId: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch AI transcription for a specific call
     */
    public function fetchCallTranscription($callId)
    {
        try {
            $response = Http::withHeaders(['Authorization' => $this->apiKey])
                ->withoutVerifying()
                ->get("{$this->baseUrl}/call-transcripts/{$callId}");

            Log::info("OpenPhone: Transcript response for $callId", [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                $data = $response->json()['data'] ?? [];
                
                // The dialogue can be in data['transcript']['dialogue'] or data['dialogue']
                $dialogue = $data['transcript']['dialogue'] ?? $data['dialogue'] ?? null;
                
                if (is_array($dialogue)) {
                    // Extract text from dialogue segments and join them
                    return collect($dialogue)->pluck('content')->filter()->implode("\n");
                }
                
                $content = $data['transcript']['content'] ?? $data['content'] ?? null;
                if (is_array($content)) {
                    return implode("\n", array_filter($content));
                }

                if (is_string($content)) {
                    return $content;
                }
            }
            return null;
        } catch (\Exception $e) {
            Log::error("OpenPhone: Failed to fetch transcription for call $callId: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get dummy data for testing
     * 
     * @return array
     */
    protected function getDummyData()
    {
        return [
            [
                'id' => 'call_' . uniqid(),
                'from' => '+15550001001',
                'to' => '+15550002002',
                'direction' => 'inbound',
                'duration' => 120,
                'recording_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
                'created_at' => now()->subMinutes(rand(1, 60))->toIso8601String(),
                'userId' => 'user_' . rand(1, 5)
            ],
            [
                'id' => 'call_' . uniqid(),
                'from' => '+15550003003',
                'to' => '+15550004004',
                'direction' => 'outbound',
                'duration' => 345,
                'recording_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
                'created_at' => now()->subMinutes(rand(60, 120))->toIso8601String(),
                'userId' => 'user_' . rand(1, 5)
            ]
        ];
    }
}
