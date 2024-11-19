<?php
namespace App\Http\Controllers;

use App\Dto\ResponseApiDto;
use App\Helpers\ReminderHelper;
use App\Jobs\SendNotificationFcmJob;
use App\Models\Medicine;
use App\Models\MExercise;
use App\Models\Reminder;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request): JsonResponse
    {
        try{
            DB::beginTransaction();
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
                'note_hypertension' => 'nullable|string',
                'exercise_id' => 'required|exists:m_exercise,id',
                'exercise_time_schedule' => 'required|date_format:H:i',
                'medicine_name' => 'nullable|string|max:255',
                'medicine_count' => 'nullable|integer',
                'fcm_token' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                DB::rollBack();
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

            $exercise = MExercise::find($request->exercise_id);
            Medicine::create(['name' => $request->medicine_name]);
            $time = ['08:00', '13:00', '20:00'];
            for ($i = 0; $i < 21; $i++) {
                $reminder1 = Reminder::create([
                    'user_id' => $user->id,
                    'title' => $exercise->exercise_name ?? 'Latihan',
                    'message' => 'Waktunya latihan',
                    'reminder_date' => now()->addDays($i),
                    'reminder_time' => $request->exercise_time_schedule ?? '06:00',
                    'type' => 'exercise',
                    'status' => 'pending',
                ]);

                $exerciseTime = explode(':', $request->exercise_time_schedule);
                dispatch(new SendNotificationFcmJob($reminder1, $user))->delay(now()->addDays($i)->setTime($exerciseTime[0], $exerciseTime[1]));

                ReminderHelper::storeReminderDefault($user->id, $i);

                if ($request->medicine_name && $request->medicine_count) {
                    for ($j = 0; $j < $request->medicine_count; $j++) {
                        $reminder = Reminder::create([
                            'user_id' => $user->id,
                            'title' => $request->medicine_name,
                            'message' => 'Waktunya minum obat',
                            'reminder_date' => now()->addDays($i),
                            'reminder_time' => $time[$j],
                            'type' => 'medicine',
                            'status' => 'pending',
                        ]);

                        dispatch(new SendNotificationFcmJob($reminder, $user))->delay(now()->addDays($i)->setTime(explode(':', $time[$j])[0], explode(':', $time[$j])[1]));
                    }
                }
            }

            $response = new ResponseApiDto(true, 201, 'User created', $user, ['token' => $token]);
            DB::commit();
            return response()->json($response->toArray(), 201);
        }catch(\Exception $e){
            DB::rollBack();
            $response = new ResponseApiDto(false, 500, 'Internal server error', $e->getMessage());
            return response()->json($response->toArray(), 500);
        }
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

        User::where('username', $request->username)->update(['token' => $token]);

        if ($request->fcm_token) {
            User::where('username', $request->username)->update(['fcm_token' => $request->fcm_token]);
        }

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
