<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function getAll()
    {
        $foodIntakes = Note::where('user_id', auth()->user()->id)->get();
        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all notes',
            data: $foodIntakes
        );

        return response()->json($response->toArray(), 200);
    }

    public function getById($id)
    {
        $foodIntake = Note::where('user_id', auth()->user()->id)->find($id);

        if (!$foodIntake) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Note not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get note by ID',
            data: $foodIntake
        );

        return response()->json($response->toArray(), 200);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);

        $validator = Validator::make($request->all(), [
            'title'   => 'required|string',
            'content'       => 'required|string',
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

        $note = Note::create($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Success create note',
            data: $note
        );

        return response()->json($response->toArray(), 201);
    }

    public function update(Request $request, $id)
    {
        $note = Note::where('user_id', auth()->user()->id)->find($id);

        if (!$note) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Note not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $validator = Validator::make($request->all(), [
            'title'   => 'required|string',
            'content'       => 'required|string',
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
            message: 'Success update note',
            data: $note
        );

        return response()->json($response->toArray(), 200);
    }

    public function delete($id)
    {
        $note = Note::where('user_id', auth()->user()->id)->find($id);

        if (!$note) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Note not found'
            );

            return response()->json($response->toArray(), 404);
        }

        $note->delete();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success delete note'
        );

        return response()->json($response->toArray(), 200);
    }
}
