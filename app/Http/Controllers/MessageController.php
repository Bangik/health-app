<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Helpers\FcmHelper;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function getMessage()
    {
        $userId = auth()->user()->id;
        $message = Message::with('sender', 'receiver')->where('sender_id', $userId)->orderBy('created_at', 'desc')->get();
        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all message',
            data: $message
        );

        return response()->json($response->toArray(), 200);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
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

        $senderId = auth()->user()->id;
        $receiverId = User::where('role', 'admin')->first()->id;
        $content = $request->content;

        $message = Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $content,
        ]);

        FcmHelper::send(
            topic: 'notification',
            title: 'New Message',
            bodyMessage: $message,
            type: 'notification',
            data: [
                'message_id' => $message->id,
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'content' => $content,
            ]
        );

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success send message',
            data: $message
        );

        return response()->json($response->toArray(), 200);
    }
}
