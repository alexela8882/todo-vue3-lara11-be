<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_details')->insert([
            [
                'user_id' => 1, // John Doe
                'email' => 'johndoe@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
            ],
            [
                'user_id' => 2, // Jane Smith
                'email' => 'janesmith@example.com',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
            ],
        ]);
    }
}
