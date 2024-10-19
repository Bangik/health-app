<?php

namespace Database\Factories;

use App\Models\MHealthControlNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MHealthControlNoteFactory extends Factory
{
    protected $model = MHealthControlNote::class;

    public function definition()
    {
        return [
            'm_user_id' => $this->faker->randomElement(User::pluck('id')),
            'systolic_pressure' => $this->faker->numberBetween(90, 180),
            'diastolic_pressure' => $this->faker->numberBetween(60, 120),
        ];
    }
}
