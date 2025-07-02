<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
// use App\Enums\UserRole;

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
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
    
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects.',
            ])->onlyInput('email');
        }
    
        $request->session()->regenerate();
    
        $user = Auth::user();
    
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('plaisance')) {
            return redirect()->route('plaisance.dashboard');
        } elseif ($user->hasRole('tresorier')) {
            return redirect()->route('tresorier.dashboard');
        } elseif ($user->hasRole('comptable')) {
            return redirect()->route('comptable.dashboard');
        } elseif ($user->hasRole('admin_juridique')) {
            return redirect()->route('admin_juridique.dashboard');
        } elseif ($user->hasRole('user')){
            return redirect()->route('user.dashboard');
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
