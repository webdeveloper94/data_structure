<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Foydalanuvchini autentifikatsiya qilish
        $request->authenticate();

        // Sessionni yangilash
        $request->session()->regenerate();

        // Foydalanuvchini roliga qarab yo'naltirish
        $user = Auth::user();

        // Foydalanuvchi rolini tekshirish
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Admin uchun marshrut
        } else {
            return redirect()->route('user.dashboard'); // Oddiy foydalanuvchi uchun marshrut
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Tizimdan chiqish
        Auth::guard('web')->logout();

        // Sessionni tozalash
        $request->session()->invalidate();

        // Tokenni yangilash
        $request->session()->regenerateToken();

        return redirect('/'); // Bosh sahifaga yo'naltirish
    }
}
