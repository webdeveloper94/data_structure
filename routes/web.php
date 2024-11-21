<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [LessonController::class, 'index'])->name('home');

// Auth routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('/', function() {
                if (Auth::user()->role !== 'admin') {
                    return redirect('/')->with('error', 'Unauthorized access.');
                }
                return app(AdminController::class)->index();
            })->name('admin.dashboard');

            Route::post('/questions', function() {
                if (Auth::user()->role !== 'admin') {
                    return redirect('/')->with('error', 'Unauthorized access.');
                }
                return app(AdminController::class)->storeQuestion(request());
            })->name('admin.questions.store');

            Route::group(['middleware' => function ($request, $next) {
                if (Auth::user()->role !== 'admin') {
                    return redirect('/')->with('error', 'Unauthorized access.');
                }
                return $next($request);
            }], function () {
                Route::resource('topics', TopicController::class)->names('admin.topics');
                Route::resource('lessons', LessonController::class)->names('admin.lessons');
                Route::resource('tests', TestController::class)->names('admin.tests');
                Route::resource('users', UserController::class)->names('admin.users');
            });
        });
    });

    // User routes
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
    Route::resource('lessons', LessonController::class)->names('lesson');
    Route::resource('topics', TopicController::class)->names('topic');
    
    Route::controller(TestController::class)->group(function () {
        Route::get('/test', 'index')->name('test.index');
        Route::get('/test/{test}', 'show')->name('test.show');
        Route::post('/test/{test}/submit', 'submit')->name('test.submit');
    });
});

require __DIR__.'/auth.php';