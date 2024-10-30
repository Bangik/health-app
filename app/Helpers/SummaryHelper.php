<?php

namespace App\Helpers;

use App\Http\Resources\DailySummaryResource;
use App\Models\User;

class SummaryHelper {
    public static function getSummary($date) {
        $summary = User::with([
            'foodIntakes' => function ($query) use ($date) {
                $query->with('recipe')->whereDate('created_at', $date);
            },
            'drinkLogs' => function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            },
            'exerciseLogs' => function ($query) use ($date) {
                $query->with('exercise')->whereDate('created_at', $date);
            },
            'healthControlNote' => function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            },
            'medicineLogs' => function ($query) use ($date) {
                $query->with('medicine')->whereDate('created_at', $date);
            },
        ])
        ->where('id', auth()->user()->id)
        ->first();

        return new DailySummaryResource($summary);
    }
}