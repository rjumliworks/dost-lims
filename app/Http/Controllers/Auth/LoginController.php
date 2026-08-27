<?php

namespace App\Http\Controllers\Auth;

use App\Mail\AccountActivationCode; 
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create(): Response|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }

        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    public function store(LoginRequest $request): RedirectResponse
{
    // 1. Authenticate credentials
    $request->authenticate();
    $user = Auth::user();
    
    // 2. Check if active FIRST. If not, destroy the session immediately.
    if (!$user->is_active) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        throw ValidationException::withMessages([
            'email' => 'Account Locked. Please contact the administrator.',
        ]);
    }

    // 3. User is valid and active, safe to persist session
    $request->session()->regenerate();
    $request->session()->put('two_factor_authenticated', false);

    // 4. Handle account activation/must change password flow
    if ($user->must_change) {
        
        // Changed to 6 digits (100000 to 999999) to match your Vue UI
        do {
            $code = random_int(100000000, 999999999);
        } while (\App\Models\User::where('code', $code)->exists());

        $user->update(['code' => $code]);
        Mail::to($user->email)->queue(new AccountActivationCode($user, $code));
        
        return redirect()->intended(route('activation', absolute: false));
    }

    // 5. Successful standard login
    return redirect()->intended(route('dashboard', absolute: false));
}

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        // Prevent session fixation attacks
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
