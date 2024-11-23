<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Models\Topic;
use App\Models\User;
use App\Models\Test;
use App\Models\Lab;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return view('welcome');
})->name('home');

// User routes
Route::prefix('user')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $topics = Topic::with(['lessons' => function ($query) {
            $query->where('status', 'published')
                ->orderBy('order');
        }])->get();
        
        return view('user.dashboard', compact('topics'));
    })->name('user.dashboard');

    // Lessons
    Route::get('/lessons', function () {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $lessons = Auth::user()->lessons()
            ->where('status', 'published')
            ->orderBy('order')
            ->paginate(10);
        
        return view('user.lessons', compact('lessons'));
    })->name('user.lessons');

    // Tests
    Route::get('/tests', function () {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $tests = Test::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.tests', compact('tests'));
    })->name('user.tests');

    // Labs
    Route::get('/labs', function () {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $labs = Lab::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.labs', compact('labs'));
    })->name('user.labs');

    // Topics
    Route::get('/topics/{topic}', function ($topic) {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $topic = Topic::with(['lessons' => function($query) {
            $query->where('status', 'published')
                  ->orderBy('order');
        }])->findOrFail($topic);
        
        return view('user.topic', compact('topic'));
    })->name('user.topics.show');
});

// CSRF Token refresh route
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/', function() {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(AdminController::class)->index();
    })->name('admin.dashboard');

    // Topic Management Routes
    Route::get('/topics', function() {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(TopicController::class)->index();
    })->name('admin.topics.index');

    Route::post('/topics', function() {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(TopicController::class)->store(request());
    })->name('admin.topics.store');

    Route::put('/topics/{topic}', function(Topic $topic) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(TopicController::class)->update(request(), $topic);
    })->name('admin.topics.update');

    Route::delete('/topics/{topic}', function(Topic $topic) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(TopicController::class)->destroy($topic);
    })->name('admin.topics.destroy');

    // Test Management Routes
    Route::group(['prefix' => 'tests', 'as' => 'admin.tests.'], function () {
        Route::get('/', [AdminController::class, 'tests'])->name('index');
        Route::post('/', [AdminController::class, 'storeTest'])->name('store');
        Route::get('/{test}/edit', [AdminController::class, 'editTest'])->name('edit');
        Route::put('/{test}', [AdminController::class, 'updateTest'])->name('update');
        Route::delete('/{test}', [AdminController::class, 'deleteTest'])->name('destroy');
        Route::get('/{test}/results', [AdminController::class, 'testResults'])->name('results');
    });

    // Lab Management Routes
    Route::group(['prefix' => 'lessons/{lesson}/labs', 'as' => 'admin.labs.'], function () {
        Route::get('/', [AdminController::class, 'labs'])->name('index');
        Route::post('/', [AdminController::class, 'storeLab'])->name('store');
        Route::get('/{lab}/edit', [AdminController::class, 'editLab'])->name('edit');
        Route::put('/{lab}', [AdminController::class, 'updateLab'])->name('update');
        Route::delete('/{lab}', [AdminController::class, 'deleteLab'])->name('destroy');
    });

    // User Management Routes
    Route::get('/users', function() {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(AdminController::class)->users();
    })->name('admin.users.index');

    Route::put('/users/{user}/role', function(User $user) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(AdminController::class)->updateRole($user, request());
    })->name('admin.users.role');

    Route::put('/users/{user}/block', function(User $user) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(AdminController::class)->blockUser($user, request());
    })->name('admin.users.block');

    Route::put('/users/{user}/unblock', function(User $user) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(AdminController::class)->unblockUser($user);
    })->name('admin.users.unblock');

    Route::put('/users/{user}/ban', function(User $user) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(AdminController::class)->banUser($user, request());
    })->name('admin.users.ban');

    Route::put('/users/{user}/unban', function(User $user) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(AdminController::class)->unbanUser($user);
    })->name('admin.users.unban');

    // Resource Routes
    Route::group(['middleware' => function ($request, $next) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return $next($request);
    }], function () {
        Route::resource('lessons', LessonController::class)->names('admin.lessons');
    });

    // Questions
    Route::post('/questions', function() {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app(AdminController::class)->storeQuestion(request());
    })->name('admin.questions.store');
});

// Profile routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // User routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::resource('lessons', LessonController::class)->names('lesson');
    Route::resource('topics', TopicController::class)->names('topic');
    
    Route::controller(TestController::class)->group(function () {
        Route::get('/test', 'index')->name('test.index');
        Route::get('/test/{test}', 'show')->name('test.show');
        Route::post('/test/{test}/submit', 'submit')->name('test.submit');
    });
});

require __DIR__.'/auth.php';