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

        // Fetch users to map IDs to names
        $users = $openPhoneService->fetchUsers();
        $userMap = collect($users)->keyBy('id');
        $this->info("Fetched " . count($users) . " users for mapping.");

        $calls = $openPhoneService->fetchCalls($date);

        // Map calls to dispatchers
        foreach ($calls as $callData) {
            $openPhoneUserId = $callData['userId'] ?? null;
            if (!$openPhoneUserId) {
                continue;
            }

            $opUser = $userMap->get($openPhoneUserId);
            $name = $opUser ? ($opUser['firstName'] . ' ' . $opUser['lastName']) : ('Unknown Dispatcher ' . $openPhoneUserId);
            $email = $opUser['email'] ?? ($openPhoneUserId . '@example.com');

            $dispatcher = Dispatcher::updateOrCreate(
                ['openphone_id' => $openPhoneUserId],
                [
                    'name' => $name,
                    'email' => $email
                ]
            );

            Call::updateOrCreate(
                ['openphone_call_id' => $callData['id']],
                [
                    'dispatcher_id' => $dispatcher->id,
                    'from_number' => $callData['from'],
                    'to_number' => $callData['to'],
                    'direction' => $callData['direction'],
                    'status' => $callData['duration'] > 0 ? 'completed' : 'missed',
                    'duration' => $callData['duration'],
                    'recording_url' => $callData['recording_url'] ?? null,
                    'called_at' => Carbon::parse($callData['created_at']),
                ]
            );
        }

        $this->info("Import completed: " . count($calls) . " calls processed.");
    }
}
