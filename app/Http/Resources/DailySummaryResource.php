<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailySummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $foodTypeIdn = [
            'breakfast' => 'Sarapan',
            'lunch' => 'Makan Siang',
            'dinner' => 'Makan Malam',
            'snack' => 'Makanan Ringan',
        ];

        $foodLogs = [];
        $foodIntakes = $this->foodIntakes
            ?->groupBy(fn($foodIntake) => $foodIntake?->recipe?->food_type)
            ->map(function ($group, $foodType) use ($foodTypeIdn) {
                $foodNames = $group->pluck('recipe.food_name')->unique()->implode(', ');
                $totalCalories = $group->sum(fn($item) => (int) $item->recipe?->calories);

                return [
                    'food_name' => $foodTypeIdn[$foodType] . ': ' . $foodNames,
                    'calories' => $totalCalories,
                ];
            })
            ->values();

        $foodLogs = [
            'total_calories' => $foodIntakes->sum('calories') . ' kcal',
            'foods' => $foodIntakes,
        ];

        $drinkLogs = [];
        $drinklog = $this->drinkLogs?->map(function ($drinkLog) {
            return [
                'drink_name' => $drinkLog->drink_name . ': ' . $drinkLog->amount . ' ml',
                'amounts' => (int) $drinkLog->amount,
            ];
        });

        $drinkLogs = [
            'total_amount' => $drinklog->sum('amounts') . ' ml',
            'drinks' => $drinklog,
        ];

        $exerciseLogs = $this->exerciseLogs?->map(function ($exerciseLog) {
            return [
                'exercise_name' => $exerciseLog->exercise?->exercise_name,
                'duration' => $exerciseLog->duration . ' menit',
                'calories_burned' => $exerciseLog->calories . ' kcal',
            ];
        });

        $bloodPleasure = $this->healthControlNote?->map(function ($bloodPressure) {
            return [
                'systolic' => $bloodPressure->systolic_pressure,
                'diastolic' => $bloodPressure->diastolic_pressure,
                'summary' => $bloodPressure->systolic_pressure . '/' . $bloodPressure->diastolic_pressure . ' mmHg',
                'created_at' => Carbon::parse($bloodPressure->created_at)->format('H:i:s'),
            ];
        });

        $medicineLogs = $this->medicineLogs?->map(function ($medicineLog) {
            return [
                'medicine_name' => $medicineLog->medicine?->name,
                'dosage' => $medicineLog->medicine?->mass,
                'summary' => $medicineLog->medicine?->name . ' ' . $medicineLog->medicine?->mass . ' (' . Carbon::parse($medicineLog->created_at)->format('H:i:s') . ')',
                'created_at' => Carbon::parse($medicineLog->created_at)->format('H:i:s'),
            ];
        });

        $notes = $this->notes?->map(function ($note) {
            return [
                'title' => $note->title,
                'content' => $note->content,
                'created_at' => Carbon::parse($note->created_at)->format('H:i:s'),
            ];
        });

        return [
            'food_logs' => $foodLogs,
            'drinklogs' => $drinkLogs,
            'exercise_logs' => $exerciseLogs,
            'blood_pressure' => $bloodPleasure,
            'medicine_logs' => $medicineLogs,
            'notes' => $notes,
        ];
    }
}
