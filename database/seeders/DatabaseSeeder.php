<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(userTableSeeder::class);
        $this->call(attendanceTableSeeder::class);
        $this->call(break_timesTableSeeder::class); 
    }
}
