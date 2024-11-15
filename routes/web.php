<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Admin dashboard view
        })->name('admin.dashboard');

        Route::get('/recipe', [RecipeController::class, 'index'])->name('admin.recipe.index');
        Route::post('/recipe', [RecipeController::class, 'store'])->name('admin.recipe.store');
        Route::put('/recipe/{recipe}', [RecipeController::class, 'update'])->name('admin.recipe.update');
        Route::delete('/recipe/{recipe}', [RecipeController::class, 'destroy'])->name('admin.recipe.destroy');

        Route::get('/medicine', [MedicineController::class, 'index'])->name('admin.medicine.index');
        Route::post('/medicine', [MedicineController::class, 'store'])->name('admin.medicine.store');
        Route::put('/medicine/{medicine}', [MedicineController::class, 'update'])->name('admin.medicine.update');
        Route::delete('/medicine/{medicine}', [MedicineController::class, 'destroy'])->name('admin.medicine.destroy');

        Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('admin.knowledge.index');
        Route::post('/knowledge', [KnowledgeController::class, 'store'])->name('admin.knowledge.store');
        Route::put('/knowledge/{knowledge}', [KnowledgeController::class, 'update'])->name('admin.knowledge.update');
        Route::delete('/knowledge/{knowledge}', [KnowledgeController::class, 'destroy'])->name('admin.knowledge.destroy');

        Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
        Route::post('/user', [UserController::class, 'store'])->name('admin.user.store');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
        Route::post('/user/message/send', [UserController::class, 'sendMessage'])->name('admin.user.sendMessage');

        Route::get('/reminder/{id}', [ReminderController::class, 'index'])->name('admin.reminder.index');
        Route::post('/reminder/{id}', [ReminderController::class, 'storeWeb'])->name('admin.reminder.storeWeb');

        Route::get('/summary-user/{id}', [UserController::class, 'summaries'])->name('admin.user.summaries');

        Route::get('/exercise', [ExerciseController::class, 'index'])->name('admin.exercise.index');
        Route::post('/exercise', [ExerciseController::class, 'store'])->name('admin.exercise.store');
        Route::put('/exercise/{exercise}', [ExerciseController::class, 'update'])->name('admin.exercise.update');
        Route::delete('/exercise/{exercise}', [ExerciseController::class, 'destroy'])->name('admin.exercise.destroy');
    });
});
