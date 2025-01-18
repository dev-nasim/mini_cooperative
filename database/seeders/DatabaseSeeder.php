<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         \App\Models\User::create([
             'name' => 'Nasim Mahmud',
             'phone' => '0189325253506',
             'address' => 'Dhaka',
             'email' => 'nasim@mail.com',
             'password' => '12345',
         ]);
    }
}
