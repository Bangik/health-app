<?php

namespace Database\Factories;

use App\Models\MExercise;
use Illuminate\Database\Eloquent\Factories\Factory;

class MExerciseFactory extends Factory
{
    protected $model = MExercise::class;

    public function definition()
    {
        return [
            'exercise_name' => $this->faker->randomElement(['Jalan', 'Lari', 'Bersepeda', 'Renang', 'Push Up', 'Sit Up', 'Pull Up', 'Plank', 'Squat', 'Deadlift']),
            'description' => $this->faker->sentence,
        ];
    }
}
