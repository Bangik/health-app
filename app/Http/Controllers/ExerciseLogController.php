<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\MExerciseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExerciseLogController extends Controller
{
    // Get all exercise logs
    public function getAll()
    {
        $exerciseLogs = MExerciseLog::with('exercise')->where('m_user_id', auth()->user()->id)->get();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all exercise logs',
            data: $exerciseLogs
        );

        return response()->json($response->toArray(), 200);
    }

    // Get a specific exercise log by ID
    public function getById($id)
    {
        $exerciseLog = MExerciseLog::with('exercise')->where('m_user_id', auth()->user()->id)->find($id);

        if (!$exerciseLog) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Exercise log not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get exercise log by ID',
            data: $exerciseLog
        );
    }

    // Store a new exercise log
    public function store(Request $request)
    {
        $request->merge(['m_user_id' => auth()->user()->id]); // Adding the user ID to the request
        $validator = Validator::make($request->all(), [
            'm_exercise_id' => 'required|exists:m_exercise,id',
            'description' => 'required|string|max:255',
            'duration' => 'required|numeric',
            'calories' => 'required|numeric',
            'distance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validator->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $exerciseLog = MExerciseLog::create($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Exercise log created successfully',
            data: $exerciseLog
        );

        return response()->json($response->toArray(), 201);
    }

    // Update an existing exercise log
    public function update(Request $request, $id)
    {
        $exerciseLog = MExerciseLog::where('m_user_id', auth()->user()->id)->find($id);

        if (!$exerciseLog) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Exercise log not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $validator = Validator::make($request->all(), [
            'm_exercise_id' => 'required|exists:m_exercise,id',
            'description' => 'required|string|max:255',
            'duration' => 'required|numeric',
            'calories' => 'required|numeric',
            'distance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validator->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $request->merge(['m_user_id' => auth()->user()->id]); // Adding the user ID to the request
        $exerciseLog->update($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Exercise log updated successfully',
            data: $exerciseLog
        );

        return response()->json($response->toArray(), 200);
    }

    // Delete an exercise log
    public function delete($id)
    {
        $exerciseLog = MExerciseLog::where('m_user_id', auth()->user()->id)->find($id);

        if (!$exerciseLog) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Exercise log not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $exerciseLog->delete();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Exercise log deleted successfully'
        );

        return response()->json($response->toArray(), 200);
    }
}
