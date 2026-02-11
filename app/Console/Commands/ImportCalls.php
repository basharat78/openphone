<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OpenPhoneService;
use App\Models\Call;
use App\Models\Dispatcher;
use Carbon\Carbon;

class ImportCalls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calls:import {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import calls from OpenPhone API';

    /**
     * Execute the console command.
     */
    public function handle(OpenPhoneService $openPhoneService)
    {
        $date = $this->argument('date') ?? now()->toDateString();
        $this->info("Importing calls for date: $date");

        // Fetch phone numbers (Inboxes) to map IDs to names
        $phoneNumbers = $openPhoneService->fetchPhoneNumbers();
        $pnMap = collect($phoneNumbers)->keyBy('id');
        $this->info("Fetched " . count($phoneNumbers) . " inboxes for mapping.");

        $callsGenerator = $openPhoneService->fetchCalls($date);

        $count = 0;
        // Map calls to dispatchers (Inboxes)
        foreach ($callsGenerator as $callData) {
            $phoneNumberId = $callData['phoneNumberId'] ?? null;
            if (!$phoneNumberId) {
                continue;
            }

            $inbox = $pnMap->get($phoneNumberId);
            $name = $inbox ? $inbox['name'] : ('Unknown Inbox ' . $phoneNumberId);
            $email = $inbox['name'] . '@example.com'; 

            $dispatcher = Dispatcher::updateOrCreate(
                ['openphone_id' => $phoneNumberId],
                [
                    'name' => $name,
                    'email' => $email
                ]
            );

            // Fetch recording URL separately now
            $recordingUrl = $openPhoneService->fetchRecordingUrl($callData['id']);
            $summary = null;
            $transcript = null;

            if ($recordingUrl && $callData['duration'] > 0) {
                $this->info("Fetching summary and transcript for call: " . $callData['id']);
                $summary = $openPhoneService->fetchCallSummary($callData['id']);
                $transcript = $openPhoneService->fetchCallTranscription($callData['id']);
            }

            Call::updateOrCreate(
                ['openphone_call_id' => $callData['id']],
                [
                    'dispatcher_id' => $dispatcher->id,
                    'from_number' => $callData['from'],
                    'to_number' => $callData['to'],
                    'direction' => $callData['direction'],
                    'status' => $callData['duration'] > 0 ? 'completed' : 'missed',
                    'duration' => $callData['duration'],
                    'recording_url' => $recordingUrl,
                    'summary' => $summary,
                    'transcript' => $transcript,
                    'called_at' => Carbon::parse($callData['created_at'])->setTimezone(config('app.timezone')),
                ]
            );
            $count++;
            if ($count % 10 == 0) {
                $this->info("Processed $count calls...");
            }
        }

        $this->info("Import completed: $count calls processed.");
    }
}
