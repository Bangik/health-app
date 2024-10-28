<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\MedicineLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicineLog>
 */
class MedicineLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = MedicineLog::class;
    public function definition(): array
    {
        return [
            'medicine_id' => $this->faker->randomElement(Medicine::pluck('id')),
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'quantity' => $this->faker->randomNumber(2),
            'datetime' => $this->faker->dateTime(),
        ];
    }
}
