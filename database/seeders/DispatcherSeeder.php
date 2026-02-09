<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dispatcher;

class DispatcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dispatcher::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'openphone_id' => 'user_1',
        ]);
        
        Dispatcher::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'openphone_id' => 'user_2',
        ]);

        Dispatcher::create([
            'name' => 'Mike Johnson',
            'email' => 'mike@example.com',
            'openphone_id' => 'user_3',
        ]);
    }
}
