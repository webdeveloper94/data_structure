<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

Route::get('/', [LessonController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin routes with middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/tests', [AdminController::class, 'storeTest'])->name('admin.tests.store');
        Route::post('/questions', [AdminController::class, 'storeQuestion'])->name('admin.questions.store');
        
        Route::resource('topics', TopicController::class)->names('admin.topics');
        Route::resource('lessons', LessonController::class)->names('admin.lessons');
        Route::resource('tests', TestController::class)->names('admin.tests');
        Route::resource('users', UserController::class)->names('admin.users');
    });
});

// User routes
Route::middleware('auth')->group(function () {
    Route::resource('lessons', LessonController::class)->names('lesson');
    Route::resource('topics', TopicController::class)->names('topic');
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
    
    Route::controller(TestController::class)->group(function () {
        Route::get('/test', 'index')->name('test.index');
        Route::get('/test/{test}', 'show')->name('test.show');
        Route::post('/test/{test}/submit', 'submit')->name('test.submit');
    });
});