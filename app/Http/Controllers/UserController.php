<?php

namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
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

        $message = Message::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'content' => $content,
        ]);

        Alert::success('Success', 'Message sent successfully');
        return redirect()->route('admin.user.index');
    }
}
