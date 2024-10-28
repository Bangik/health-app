<?php

namespace Database\Factories;

use App\Models\DrinkLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DrinkLog>
 */
class DrinkLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DrinkLog::class;
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'drink_name' => $this->faker->name,
            'amount' => $this->faker->randomDigit,
        ];
    }
}
