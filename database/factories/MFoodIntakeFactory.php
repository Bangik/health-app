<?php

namespace Database\Factories;

use App\Models\MFoodIntake;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MFoodIntakeFactory extends Factory
{
    protected $model = MFoodIntake::class;

    public function definition()
    {
        return [
            'm_user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'recipe_id' => $this->faker->randomElement(Recipe::pluck('id')->toArray()),
        ];
    }
}
