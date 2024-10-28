<?php

namespace Database\Seeders;

use App\Models\DrinkLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrinkLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DrinkLog::factory(20)->create();
    }
}
