<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Helpers\FcmHelper;
use App\Helpers\SummaryHelper;
use App\Http\Resources\DailySummaryResource;
use App\Http\Resources\FoodLogResource;
use App\Models\Message;
use App\Models\MFoodIntake;
use App\Models\Note;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $adminId = auth()->user()->id;
        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->paginate(10);
        // Fetch messages for each user
        foreach ($users as $user) {
            $user->messages = $user->chatWithAdmin($adminId); // Load messages with admin
        }

        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'education' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'duration_of_hypertension' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'gender' => 'required|string|max:255|in:M,F',
        ]);

        if ($validation->fails()) {
            // implode all errors
            $errors = implode(', ', $validation->errors()->all());
            Alert::error('Error', $errors);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'date_of_birth' => $request->date_of_birth,
            'education' => $request->education,
            'occupation' => $request->occupation,
            'duration_of_hypertension' => $request->duration_of_hypertension,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'password' => bcrypt($request->username),
        ]);

        Alert::success('Success', 'User added successfully');
        return redirect()->route('admin.user.index');
    }

    public function update(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'education' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'duration_of_hypertension' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'gender' => 'required|string|max:255|in:M,F',
        ]);

        if ($validation->fails()) {
            Alert::error('Error', 'Please fill all the required fields');
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'date_of_birth' => $request->date_of_birth,
            'education' => $request->education,
            'occupation' => $request->occupation,
            'duration_of_hypertension' => $request->duration_of_hypertension,
            'phone_number' => $request->phone_number,
        ]);

        Alert::success('Success', 'User updated successfully');
        return redirect()->route('admin.user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('Success', 'User deleted successfully');
        return redirect()->route('admin.user.index');
    }

    public function sendMessage(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validation->fails()) {
            $errors = implode(', ', $validation->errors()->all());
            Alert::error('Error', $errors);
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $content = $request->content;

        Message::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'content' => $content,
        ]);

        $fcmToken = User::find($request->receiver_id)->fcm_token;

        if ($fcmToken) {
            FcmHelper::sendWithFcm(
                title: 'New Message',
                bodyMessage: $content,
                type: 'notification',
                fcmToken: $fcmToken
            );
        }

        Alert::success('Success', 'Message sent successfully');
        return redirect()->route('admin.user.index');
    }

    public function dailySummary(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validation->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get daily summary',
            data: SummaryHelper::getSummary($request->date)
        );

        return response()->json($response->toArray(), 200);
    }

    public function getAllDailySummary()
    {

        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[$date] = SummaryHelper::getSummary($date);
        }

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success get all daily summary',
            data: $dates
        );

        return response()->json($response->toArray(), 200);
    }

    public function summaries(Request $request, $id)
    {

        $dates = [];
        $firstDate = null;
        $lastDate = null;

        if ($request->first_date && $request->last_date) {
            $firstDate = Carbon::parse($request->first_date);
            $lastDate = Carbon::parse($request->last_date);

            for ($date = $firstDate; $date->lte($lastDate); $date->addDay()) {
                $dates[$date->format('Y-m-d')] = SummaryHelper::getSummary($date->format('Y-m-d'), $id);
            }

            // format date to yyyy-mm-dd
            $firstDate = $firstDate->format('Y-m-d');
            $lastDate = $lastDate->format('Y-m-d');
        } else {
            for ($i = 0; $i < 14; $i++) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $dates[$date] = SummaryHelper::getSummary($date, $id);
            }
        }

        return view('admin.user.summary', compact('id', 'dates', 'firstDate', 'lastDate'));
    }

    public function notes(Request $request, $id)
    {
        $notes = Note::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.user.note', compact('id', 'notes'));
    }
    
    public function sendTestNotif(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'message' => 'string',
        ]);

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validation->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $message = $request->message ?? 'This is a test notification';
        
        $res = FcmHelper::send(
            topic: 'notification',
            title: 'Test Notification',
            bodyMessage: $message,
            type: 'notification',
        );

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success send test notification',
            data: $res
        );

        return response()->json($response->toArray(), 200);
    }

    public function sendTestNotifWithTopic(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'message' => 'string',
        ]);

        $userId = auth()->user()->id;

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validation->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $message = $request->message ?? 'This is a test notification';
        
        $res = FcmHelper::send(
            topic: 'notification' . $userId,
            title: 'Test Notification',
            bodyMessage: $message,
            type: 'notification',
        );

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success send test notification',
            data: $res
        );

        return response()->json($response->toArray(), 200);
    }

    public function sendTestNotifWithFCM(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'message' => 'string',
        ]);

        $fcmToken = auth()->user()->fcm_token ?? '';

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validation->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $message = $request->message ?? 'This is a test notification';
        
        $res = FcmHelper::sendWithFcm(
            title: 'Test Notification',
            bodyMessage: $message,
            type: 'notification',
            fcmToken: $fcmToken
        );

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success send test notification',
            data: [
                'fcm_token' => $fcmToken,
                'response' => $res,
                'message' => $message
            ],
        );

        return response()->json($response->toArray(), 200);
    }

    public function updateFcmToken(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'fcm_token' => 'required|string',
        ]);

        if ($validation->fails()) {
            $response = new ResponseApiDto(
                status: false,
                code: 400,
                message: 'Validation error',
                data: $validation->errors()
            );

            return response()->json($response->toArray(), 400);
        }

        $user = auth()->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();

        $response = new ResponseApiDto(
            status: true,
            code: 200,
            message: 'Success update FCM token',
            data: $user
        );

        Log::info('FCM token updated for user', ['user' => $user, 'fcm_token' => $request->fcm_token]);

        return response()->json($response->toArray(), 200);
    }
}
