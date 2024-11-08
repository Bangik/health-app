<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Recipe::class;
    public function definition(): array
    {
        return [
            'food_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'food_type' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snack']),
            'portion' => $this->faker->randomElement(['small', 'medium', 'large']),
            'calories' => $this->faker->randomFloat(2, 0.5, 10),
            'protein' => $this->faker->randomFloat(2, 0.5, 10),
            'fat' => $this->faker->randomFloat(2, 0.5, 10),
            'carbohydrate' => $this->faker->randomFloat(2, 0.5, 10),
            'sugar' => $this->faker->randomFloat(2, 0.5, 10),
            'potassium' => $this->faker->randomFloat(2, 0.5, 10),
            'mass' => $this->faker->randomFloat(2, 0.5, 10),
            'image' => 'default.jpg',
        ];
    }
}
