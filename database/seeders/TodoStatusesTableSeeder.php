<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TodoStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('todo_statuses')->insert([
            ['name' => 'Pending'],
            ['name' => 'In Progress'],
            ['name' => 'Completed'],
        ]);
    }
}
