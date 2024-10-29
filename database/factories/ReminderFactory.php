<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Reminder::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
            'reminder_date' => $this->faker->date(),
            'reminder_time' => $this->faker->time(),
            'type' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snack', 'drink', 'exercise', 'medicine', 'reading', 'other']),
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'user_id' => $this->faker->randomElement(User::pluck('id')),
        ];
    }
}
