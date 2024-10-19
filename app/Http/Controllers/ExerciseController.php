<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\MExercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // Fetch all exercises
    public function getExercises()
    {
        $exercises = MExercise::all();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all exercises',
            data: $exercises
        );
        
        return response()->json($response->toArray(), 200);
    }

    // Fetch a specific exercise by ID
    public function getExerciseById($id)
    {
        $exercise = MExercise::find($id);

        if (!$exercise) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Exercise not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get exercise by ID',
            data: $exercise
        );

        return response()->json($response->toArray(), 200);
    }
}
