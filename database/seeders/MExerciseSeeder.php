<?php

namespace Database\Seeders;

use App\Models\MExercise;
use Illuminate\Database\Seeder;

class MExerciseSeeder extends Seeder
{
    public function run()
    {
        // Create 10 exercises
        MExercise::factory(10)->create();
    }
}
