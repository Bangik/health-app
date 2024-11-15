<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\MExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = MExercise::orderBy('id', 'desc')->paginate(10);
        return view('admin.exercise.index', compact('exercises'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'exercise_name' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validation->fails()) {
            $errors = implode(', ', $validation->errors()->all());
            Alert::error('Error', $errors);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        MExercise::create([
            'exercise_name' => $request->exercise_name,
            'description' => $request->description,
        ]);

        Alert::success('Success', 'Exercise created successfully');
        return redirect()->route('admin.exercise.index');
    }

    public function update(Request $request, MExercise $exercise)
    {
        $validation = Validator::make($request->all(), [
            'exercise_name' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validation->fails()) {
            $errors = implode(', ', $validation->errors()->all());
            Alert::error('Error', $errors);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $exercise->update([
            'exercise_name' => $request->exercise_name,
            'description' => $request->description,
        ]);

        Alert::success('Success', 'Exercise updated successfully');
        return redirect()->route('admin.exercise.index');
    }

    public function destroy(MExercise $exercise)
    {
        $exercise->delete();

        Alert::success('Success', 'Exercise deleted successfully');
        return redirect()->route('admin.exercise.index');
    }

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
