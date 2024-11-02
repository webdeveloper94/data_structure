<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LessonController::class, 'index'])->name('home');;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';


Route::resource('/lesson', LessonController::class);
Route::resource('/topic', TopicController::class);

Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/user', [UserController::class, 'index'])->name('user.dashboard')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/test', [TestController::class, 'index'])->name('test.index');
    Route::post('/test', [TestController::class, 'store'])->name('test.store');
    Route::get('/test/results/{id}', [TestController::class, 'results'])->name('test.results');
});