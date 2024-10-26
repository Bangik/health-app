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
            'calories' => $this->faker->numberBetween(50, 700) . ' kcal',
            'protein' => $this->faker->numberBetween(1, 50) . ' g',
            'fat' => $this->faker->numberBetween(1, 50) . ' g',
            'carbohydrate' => $this->faker->numberBetween(1, 200) . ' g',
            'sugar' => $this->faker->numberBetween(1, 100) . ' g',
            'cholesterol' => $this->faker->numberBetween(1, 100) . ' mg',
            'mass' => $this->faker->numberBetween(50, 500) . ' g',
            'image' => $this->faker->imageUrl(),
        ];
    }
}
