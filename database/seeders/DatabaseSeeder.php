<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $basic_data = database_path('sql/bcp_test.sql');
        DB::unprepared(file_get_contents($basic_data));
        $this->command->info('Basic table seeded!');
    }
}
