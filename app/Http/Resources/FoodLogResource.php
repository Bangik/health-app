<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $foodIntakes = $this->map(function ($foodIntake) {
            return [
                'food_name' => $foodIntake?->recipe?->food_type . ': ' . $foodIntake?->recipe?->food_name,
                'calories' => (int)$foodIntake->recipe?->calories,
            ];
        });

        return [
            'total_calories' => $foodIntakes?->sum('calories') . ' kcal',
            'foods' => $foodIntakes,
        ];
    }
}
