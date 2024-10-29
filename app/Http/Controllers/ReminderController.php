<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReminderController extends Controller
{
    public function index($id)
    {
        $reminders = Reminder::where('user_id', $id)->get();
        return view('admin.reminder.index', compact('reminders'));
    }

    public function getAll()
    {
        $foodIntakes = Reminder::where('user_id', auth()->user()->id)->get();
        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all reminders',
            data: $foodIntakes
        );

        return response()->json($response->toArray(), 200);
    }

    public function getById($id)
    {
        $reminder = Reminder::where('user_id', auth()->user()->id)->find($id);
        if (!$reminder) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Reminder not found',
                data: null
            );

            return response()->json($response->toArray(), 404);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get reminder',
            data: $reminder
        );

        return response()->json($response->toArray(), 200);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);

        $validator = Validator::make($request->all(), [
            'title'   => 'required|string',
            'message' => 'required|string',
            'reminder_date' => 'required|date',
            'reminder_time' => 'required|date_format:H:i',
            'type' => 'required|string|in:breakfast,lunch,dinner,snack,drink,exercise,medicine,reading,other',
            'status' => 'required|string|in:pending,completed',
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

        $reminder = Reminder::create($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 201,
            message: 'Success create reminder',
            data: $reminder
        );

        return response()->json($response->toArray(), 201);
    }

    public function update(Request $request, $id)
    {
        $reminder = Reminder::where('user_id', auth()->user()->id)->find($id);
        if (!$reminder) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Reminder not found',
                data: null
            );

            return response()->json($response->toArray(), 404);
        }

        $validator = Validator::make($request->all(), [
            'title'   => 'required|string',
            'message' => 'required|string',
            'reminder_date' => 'required|date',
            'reminder_time' => 'required|date_format:H:i',
            'type' => 'required|string|in:breakfast,lunch,dinner,snack,drink,exercise,medicine,reading,other',
            'status' => 'required|string|in:pending,completed',
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

        $reminder->update($request->all());

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success update reminder',
            data: $reminder
        );

        return response()->json($response->toArray(), 200);
    }

    public function delete($id)
    {
        $reminder = Reminder::where('user_id', auth()->user()->id)->find($id);
        if (!$reminder) {
            $response = new ResponseApiDto(
                status: false,
                code: 404,
                message: 'Reminder not found',
                data: null
            );

            return response()->json($response->toArray(), 404);
        }

        $reminder->delete();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success delete reminder',
            data: null
        );

        return response()->json($response->toArray(), 200);
    }
}
