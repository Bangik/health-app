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
        $foodLogs = [];
        $foodIntakes = $this->foodIntakes?->map(function ($foodIntake) {
            return [
                'food_name' => $foodIntake?->recipe?->food_type . ': ' . $foodIntake?->recipe?->food_name,
                'calories' => (int)$foodIntake->recipe?->calories,
            ];
        });

        $foodLogs = [
            'total_calories' => $foodIntakes?->sum('calories') . ' kcal',
            'foods' => $foodIntakes,
        ];

        $drinklogs = $this->drinklogs?->sum('amount') . ' ml (' . $this->drinklogs?->count() . ' kali minum)';

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

        return [
            'food_logs' => $foodLogs,
            'drinklogs' => $drinklogs,
            'exercise_logs' => $exerciseLogs,
            'blood_pressure' => $bloodPleasure,
            'medicine_logs' => $medicineLogs,
        ];
    }
}
