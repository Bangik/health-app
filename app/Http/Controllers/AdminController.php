<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Assuming 'm_user' table is managed by the User model

class AdminController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt login
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Check if the user is an admin
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard'); // Redirect to admin dashboard
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors(['error' => 'Access denied']);
            }
        }

        // If login fails
        return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
    }

    // Logout the admin
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
