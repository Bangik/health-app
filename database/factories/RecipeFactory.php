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
            'calories' => $this->faker->numberBetween(50, 700),
            'protein' => $this->faker->numberBetween(1, 50),
            'fat' => $this->faker->numberBetween(1, 50),
            'carbohydrate' => $this->faker->numberBetween(1, 200),
            'sugar' => $this->faker->numberBetween(1, 100),
            'cholesterol' => $this->faker->numberBetween(1, 100),
            'mass' => $this->faker->numberBetween(50, 500),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
