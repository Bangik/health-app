<?php

namespace Database\Factories;

use App\Models\MFoodIntake;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MFoodIntakeFactory extends Factory
{
    protected $model = MFoodIntake::class;

    public function definition()
    {
        return [
            'm_user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'food_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'food_type' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snack']),
            'portion' => $this->faker->randomElement(['small', 'medium', 'large']),
            'calories' => $this->faker->numberBetween(50, 700) . ' kcal',
            'protein' => $this->faker->numberBetween(1, 50) . ' g',
            'fat' => $this->faker->numberBetween(1, 50) . ' g',
            'carbohydrate' => $this->faker->numberBetween(1, 200) . ' g',
            'sugar' => $this->faker->numberBetween(1, 100) . ' g',
            'cholesterol' => $this->faker->numberBetween(1, 100) . ' mg',
            'mass' => $this->faker->numberBetween(50, 500) . ' g',
        ];
    }
}
