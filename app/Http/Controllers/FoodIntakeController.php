<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\MFoodIntake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodIntakeController extends Controller
{
    // Get all food intake records
    public function getAll()
    {
        $foodIntakes = MFoodIntake::with('recipe')->where('m_user_id', auth()->user()->id)->get();
        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all food intakes',
            data: $foodIntakes
        );

        return response()->json($response->toArray(), 200);
    }

    // Get a specific food intake by ID
    public function getById($id)
    {
        $foodIntake = MFoodIntake::with('recipe')->where('m_user_id', auth()->user()->id)->find($id);

        if (!$foodIntake) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Food intake not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get food intake by ID',
            data: $foodIntake
        );

        return response()->json($response->toArray(), 200);
    }

    // Store a new food intake record
    public function store(Request $request)
    {
        $request->merge(['m_user_id' => auth()->user()->id]); // Adding the user ID to the request

        $validator = Validator::make($request->all(), [
            'm_user_id'    => 'required|exists:m_user,id', // Ensuring the user ID exists in the m_user table
            'recipe_id'    => 'required|exists:recipes,id', // Ensuring the recipe ID exists in the recipe table
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

        $foodIntake = MFoodIntake::create($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Food intake created',
            data: $foodIntake
        );

        return response()->json($response->toArray(), 201);
    }

    // Update an existing food intake record
    public function update(Request $request, $id)
    {
        $foodIntake = MFoodIntake::where('m_user_id', auth()->user()->id)->find($id);

        if (!$foodIntake) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Food intake not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $request->merge(['m_user_id' => auth()->user()->id]); // Adding the user ID to the request

        $validator = Validator::make($request->all(), [
            'm_user_id'    => 'exists:m_user,id', // Ensuring the user ID exists in the m_user table
            'recipe_id'    => 'exists:recipes,id', // Ensuring the recipe ID exists in the recipe table
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

        $foodIntake->update($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Food intake updated',
            data: $foodIntake
        );

        return response()->json($response->toArray(), 200);
    }

    // Delete a food intake record
    public function delete($id)
    {
        $foodIntake = MFoodIntake::where('m_user_id', auth()->user()->id)->find($id);

        if (!$foodIntake) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Food intake not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $foodIntake->delete();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Food intake deleted'
        );
    }
}

