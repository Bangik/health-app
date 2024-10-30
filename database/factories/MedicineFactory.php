<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Medicine::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['tablet', 'capsule', 'syrup', 'injection']),
            'mass' => $this->faker->randomDigit,
            'how_to_use' => $this->faker->sentence,
            'side_effects' => $this->faker->sentence,
            'indications' => $this->faker->sentence,
            'warnings' => $this->faker->sentence,
            'image' => 'default.jpg',
        ];
    }
}
