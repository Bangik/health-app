<?php
namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:m_user',
            'password' => 'required|string|min:6|confirmed',
            'date_of_birth' => 'nullable|date',
            'education' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'duration_of_hypertension' => 'nullable|integer',
            'phone_number' => 'nullable|string|max:15',
            'gender' => 'nullable|in:M,F',
            'fcm_token' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $response = new ResponseApiDto(false, 400, 'Validation error', $validator->errors());
            return response()->json($response->toArray(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'education' => $request->education,
            'occupation' => $request->occupation,
            'duration_of_hypertension' => $request->duration_of_hypertension,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'fcm_token' => $request->fcm_token ?? null,
        ]);

        $token = JWTAuth::fromUser($user);

        User::where('id', $user->id)->update(['token' => $token]);

        $response = new ResponseApiDto(true, 201, 'User created', $user, ['token' => $token]);
        return response()->json($response->toArray(), 201);
    }

    // Login a user
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'fcm_token' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $response = new ResponseApiDto(false, 400, 'Validation error', $validator->errors());
            return response()->json($response->toArray(), 400);
        }
        
        $credentials = $request->only('username', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            $response = new ResponseApiDto(false, 401, 'Invalid credentials');
            return response()->json($response->toArray(), 401);
        }

        User::where('username', $request->username)->update(['fcm_token' => $request->fcm_token ?? null, 'token' => $token]);

        return $this->respondWithToken($token, auth()->user());
    }

    // Get the authenticated user's profile
    public function me()
    {
        $response = new ResponseApiDto(true, 200, 'User profile', auth()->user());
        return response()->json($response->toArray(), 200);
    }

    // Logout the user
    public function logout()
    {
        $user = auth()->user();
        User::where('id', $user->id)->update(['fcm_token' => null, 'token' => null]);

        auth()->logout();

        // revoke the token
        JWTAuth::invalidate(JWTAuth::getToken());

        $response = new ResponseApiDto(true, 200, 'Successfully logged out');
        return response()->json($response->toArray(), 200);
    }

    // Refresh the JWT token
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token, $user = null)
    {
        $response = new ResponseApiDto(true, 200, 'Success', $user, ['token' => $token]);
        return response()->json($response->toArray(), 200);
    }
}
