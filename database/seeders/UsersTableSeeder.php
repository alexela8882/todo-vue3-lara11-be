<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'user_type_id' => 1, // Admin
                'name' => 'John Doe',
                'username' => 'johndoe',
                'password' => Hash::make('password123'), // Change as necessary
            ],
            [
                'user_type_id' => 2, // User
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'password' => Hash::make('password123'), // Change as necessary
            ],
        ]);
    }
}
