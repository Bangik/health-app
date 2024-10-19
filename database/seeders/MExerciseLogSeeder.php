<?php

namespace Database\Seeders;

use App\Models\MExerciseLog;
use Illuminate\Database\Seeder;

class MExerciseLogSeeder extends Seeder
{
    public function run()
    {
        // Create 10 exercise log records
        MExerciseLog::factory(10)->create();
    }
}
