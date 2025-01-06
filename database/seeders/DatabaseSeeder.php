<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Project::factory()->count(10)->create();
        Task::factory()->count(40)->create();
    }
}
