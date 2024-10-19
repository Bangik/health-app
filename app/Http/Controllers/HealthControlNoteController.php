<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\MHealthControlNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HealthControlNoteController extends Controller
{
    // Get all health control notes
    public function getAll()
    {
        $notes = MHealthControlNote::where('m_user_id', auth()->user()->id)->get();
        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all health control notes',
            data: $notes
        );

        return response()->json($response->toArray(), 200);
    }

    // Get a specific health control note by ID
    public function getById($id)
    {
        $note = MHealthControlNote::where('m_user_id', auth()->user()->id)->find($id);

        if (!$note) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Health control note not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get health control note by ID',
            data: $note
        );

        return response()->json($response->toArray(), 200);
    }

    // Store a new health control note
    public function store(Request $request)
    {
        $request->merge(['m_user_id' => auth()->user()->id]); // Adding the user ID to the request
        $validator = Validator::make($request->all(), [
            'm_user_id' => 'required|exists:m_user,id',
            'systolic_pressure' => 'required|numeric',
            'diastolic_pressure' => 'required|numeric',
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

        $note = MHealthControlNote::create($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Health control note created successfully',
            data: $note
        );

        return response()->json($response->toArray(), 201);
    }

    // Update an existing health control note
    public function update(Request $request, $id)
    {
        $note = MHealthControlNote::where('m_user_id', auth()->user()->id)->find($id);

        if (!$note) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Health control note not found'
            );

            return response()->json($response->toArray(), 404);
        }


        $request->merge(['m_user_id' => auth()->user()->id]); // Adding the user ID to the request
        $validator = Validator::make($request->all(), [
            'systolic_pressure' => 'required|numeric',
            'diastolic_pressure' => 'required|numeric',
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

        $note->update($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Health control note updated successfully',
            data: $note
        );

        return response()->json($response->toArray(), 200);
    }

    // Delete a health control note
    public function delete($id)
    {
        $note = MHealthControlNote::where('m_user_id', auth()->user()->id)->find($id);

        if (!$note) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Health control note not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $note->delete();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Health control note deleted successfully'
        );

        return response()->json($response->toArray(), 200);
    }
}
