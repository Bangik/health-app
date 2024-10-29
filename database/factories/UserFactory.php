<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'date_of_birth' => $this->faker->date(),
            'education' => $this->faker->randomElement(['High School', 'Bachelor', 'Master', 'PhD']),
            'occupation' => $this->faker->jobTitle,
            'duration_of_hypertension' => $this->faker->numberBetween(1, 20), // duration in years
            'phone_number' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['M', 'F']),
            'note_hypertension' => $this->faker->sentence,
            'role' => 'user', // default role
            'password' => bcrypt('password'), // default password or hashed random password
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
}
