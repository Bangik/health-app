<?php

namespace Database\Factories;

use App\Models\MExerciseLog;
use App\Models\MExercise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MExerciseLogFactory extends Factory
{
    protected $model = MExerciseLog::class;

    public function definition()
    {
        return [
            'm_user_id' => $this->faker->randomElement(User::pluck('id')),
            'm_exercise_id' => $this->faker->randomElement(MExercise::pluck('id')),
            'description' => $this->faker->sentence,
            'duration' => $this->faker->numberBetween(10, 120),
            'calories' => $this->faker->numberBetween(100, 1000),
            'distance' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
