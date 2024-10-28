<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(MUserSeeder::class);
        $this->call(MExerciseSeeder::class);
        $this->call(RecipeSeeder::class);
        $this->call(MFoodIntakeSeeder::class);
        $this->call(MKnowledgeSeeder::class);
        $this->call(MExerciseLogSeeder::class);
        $this->call(MHealthControlNoteSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(MedicineSeeder::class);
        $this->call(DrinkLogSeeder::class);
    }
}
