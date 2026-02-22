<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Volunteer;
use App\Models\Task;
use App\Models\Location;

class InitialDataSeeder extends Seeder
{
public function run()
    {
Volunteer::insert([
    ['name' => 'Ahmad Ali', 'email' => 'ahmad@example.com', 'phone' => '0591234567'],
    ['name' => 'Sara Omar', 'email' => 'sara@example.com', 'phone' => '0597654321'],
    ['name' => 'Mona Saleh', 'email' => 'mona@example.com', 'phone' => '0591122334'],
]);
        Task::insert([
            ['name' => 'Distribution'],
            ['name' => 'Monitoring'],
            ['name' => 'Administration'],
        ]);

        Location::insert([
            ['name' => 'Health Clinic'],
            ['name' => 'Aid Distribution Center'],
        ]);
    }
}
