<?php

namespace Database\Seeders;

use App\Models\MFoodIntake;
use Illuminate\Database\Seeder;

class MFoodIntakeSeeder extends Seeder
{
    public function run()
    {
        // Create 10 food intake records
        MFoodIntake::factory(10)->create();
    }
}
