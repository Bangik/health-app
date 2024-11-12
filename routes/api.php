<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DrinkLogController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseLogController;
use App\Http\Controllers\FoodIntakeController;
use App\Http\Controllers\HealthControlNoteController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicineLogController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/schedule-fcm', function () {
//     Artisan::call('app:send-notification-fcm-command');
//     return response()->json([
//         'message'   => 'Command executed successfully',
//         'output'    => Artisan::output()
//     ]);
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('exercises', [ExerciseController::class, 'getExercises']);
Route::get('exercises/{id}', [ExerciseController::class, 'getExerciseById']);

Route::get('knowledge', [KnowledgeController::class, 'getAll']);
Route::get('knowledge/{id}', [KnowledgeController::class, 'getById']);

Route::get('medicines', [MedicineController::class, 'getMedicines']);
Route::get('medicines/{id}', [MedicineController::class, 'getMedicineById']);

Route::get('recipes', [RecipeController::class, 'getRecipes']);
Route::get('recipes/{id}', [RecipeController::class, 'getRecipeById']);

Route::get('test-notif', [UserController::class, 'sendTestNotif']);
Route::get('job', [JobController::class, 'index']);
Route::get('job/failed', [JobController::class, 'failedJob']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('daily-summary', [UserController::class, 'dailySummary']);
    Route::get('all-daily-summary', [UserController::class, 'getAllDailySummary']);
    Route::get('test-notif-with-fcm', [UserController::class, 'sendTestNotifWithFCM']);

    Route::group(['prefix' => 'food-intake'], function() {
        Route::get('/', [FoodIntakeController::class, 'getAll']);
        Route::get('/{id}', [FoodIntakeController::class, 'getById']);
        Route::post('/', [FoodIntakeController::class, 'store']);
        Route::put('/{id}', [FoodIntakeController::class, 'update']);
        Route::delete('/{id}', [FoodIntakeController::class, 'delete']);
    });

    Route::group(['prefix' => 'exercise-log'], function() {
        Route::get('/', [ExerciseLogController::class, 'getAll']);
        Route::get('/{id}', [ExerciseLogController::class, 'getById']);
        Route::post('/', [ExerciseLogController::class, 'store']);
        Route::put('/{id}', [ExerciseLogController::class, 'update']);
        Route::delete('/{id}', [ExerciseLogController::class, 'delete']);
    });

    Route::group(['prefix' => 'health-control-note'], function() {
        Route::get('/', [HealthControlNoteController::class, 'getAll']);
        Route::get('/{id}', [HealthControlNoteController::class, 'getById']);
        Route::post('/', [HealthControlNoteController::class, 'store']);
        Route::put('/{id}', [HealthControlNoteController::class, 'update']);
        Route::delete('/{id}', [HealthControlNoteController::class, 'delete']);
    });

    Route::group(['prefix' => 'drink-log'], function() {
        Route::get('/', [DrinkLogController::class, 'getAll']);
        Route::get('/{id}', [DrinkLogController::class, 'getById']);
        Route::post('/', [DrinkLogController::class, 'store']);
        Route::put('/{id}', [DrinkLogController::class, 'update']);
        Route::delete('/{id}', [DrinkLogController::class, 'delete']);
    });

    Route::group(['prefix' => 'medicine-log'], function() {
        Route::get('/', [MedicineLogController::class, 'getAll']);
        Route::get('/{id}', [MedicineLogController::class, 'getById']);
        Route::post('/', [MedicineLogController::class, 'store']);
        Route::put('/{id}', [MedicineLogController::class, 'update']);
        Route::delete('/{id}', [MedicineLogController::class, 'delete']);
    });

    Route::group(['prefix' => 'message'], function() {
        Route::get('/', [MessageController::class, 'getMessage']);
        Route::post('/', [MessageController::class, 'sendMessage']);
    });

    Route::group(['prefix' => 'recipes'], function() {
        Route::post('/', [RecipeController::class, 'storeRecipe']);
        Route::post('/{id}', [RecipeController::class, 'updateRecipe']);
    });

    Route::group(['prefix' => 'medicines'], function() {
        Route::post('/', [MedicineController::class, 'storeMedicine']);
        Route::post('/{id}', [MedicineController::class, 'updateMedicine']);
    });

    Route::group(['prefix' => 'notes'], function() {
        Route::get('/', [NoteController::class, 'getAll']);
        Route::get('/{id}', [NoteController::class, 'getById']);
        Route::post('/', [NoteController::class, 'store']);
        Route::put('/{id}', [NoteController::class, 'update']);
        Route::delete('/{id}', [NoteController::class, 'delete']);
    });

    Route::group(['prefix' => 'reminders'], function() {
        Route::get('/', [ReminderController::class, 'getAll']);
        Route::get('/{id}', [ReminderController::class, 'getById']);
        Route::post('/', [ReminderController::class, 'store']);
        Route::put('/{id}', [ReminderController::class, 'update']);
        Route::delete('/{id}', [ReminderController::class, 'delete']);
    });
});
