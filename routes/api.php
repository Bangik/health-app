<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseLogController;
use App\Http\Controllers\FoodIntakeController;
use App\Http\Controllers\HealthControlNoteController;
use App\Http\Controllers\KnowledgeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('exercises', [ExerciseController::class, 'getExercises']);
Route::get('exercises/{id}', [ExerciseController::class, 'getExerciseById']);

Route::get('knowledge', [KnowledgeController::class, 'getAll']);
Route::get('knowledge/{id}', [KnowledgeController::class, 'getById']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);

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
});
