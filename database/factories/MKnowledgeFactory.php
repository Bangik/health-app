<?php

namespace Database\Factories;

use App\Models\MKnowledge;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MKnowledgeFactory extends Factory
{
    protected $model = MKnowledge::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'slug' => Str::slug($this->faker->sentence),
            'image' => 'default.jpg',
        ];
    }
}
