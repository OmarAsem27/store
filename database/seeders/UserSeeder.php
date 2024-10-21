<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Omar Asem',
            'email' => 'omar@g.ps',
            'password' => Hash::make('password'),
            'phone_number' => '123456789123',
        ]);

        DB::table('users')->insert([
            'name' => 'Mohamed',
            'email' => 'mohamed@g.com',
            'password' => Hash::make('password'),
            'phone_number' => '1223456789123'
        ]);
    }
}
