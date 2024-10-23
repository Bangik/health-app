<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        return [
            'sender_id' => $this->faker->randomElement(User::pluck('id')),
            'receiver_id' => $this->faker->randomElement(User::pluck('id')),
            'content' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['sent', 'delivered', 'read']),
        ];
    }
}
