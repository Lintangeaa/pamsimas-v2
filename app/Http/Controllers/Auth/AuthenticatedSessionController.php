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
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect()->intended(route('dashboard', [], false)); // Redirect to admin dashboard
        } elseif (Auth::user()->role === 'pelanggan') {
            return redirect()->intended(route('pelanggan.tagihan.index', [], false)); // Redirect to pelanggan tagihan page
        } else {
            // Default redirect if role is not recognized
            return redirect()->intended(route('dashboard', [], false)); // Modify as per your application's default behavior
        }
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
