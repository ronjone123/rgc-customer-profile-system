<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;


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
  public function store(LoginRequest $request)
{
    // Attempt authentication (Breeze default)
    $request->authenticate();

    // 🔒 BLOCK suspended users immediately
    if (auth()->user()->status === 'suspended') {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors([
            'email' => 'Your account has been suspended. Please contact support.',
        ]);
    }

    // Regenerate session for active users
    $request->session()->regenerate();

    $user = auth()->user();

    // Role-based redirect
    return match ($user->role) {
        User::ROLE_SUPERADMIN    => redirect('/superadmin'),
        User::ROLE_HEAD_ADMIN    => redirect('/admin'),
        User::ROLE_BRANCH_ADMIN  => redirect('/branch'),
        default                 => redirect('/dashboard'),
    };
}



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
