<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('todos')->insert([
            [
                'user_id' => 1, // John Doe
                'todo_status_id' => 1, // Pending
                'todo' => 'Create Vue.js application',
                'description' => 'Setup Vue 3 with Laravel backend.',
            ],
            [
                'user_id' => 2, // Jane Smith
                'todo_status_id' => 2, // In Progress
                'todo' => 'Design the API',
                'description' => 'Design the RESTful API endpoints for the application.',
            ],
        ]);
    }
}
