<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
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
        $request->ensureIsNotRateLimited();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($request->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($request->throttleKey());
        
        $request->session()->regenerate();

        $user = auth()->user();

        Log::info('User authenticated:', ['user_id' => $user->id, 'email' => $user->email]);

        try {
            // Generate OTP
            $otp = rand(100000, 999999);
            $updated = $user->update([
                'two_factor_otp' => $otp,
                'two_factor_otp_expires_at' => now()->addMinutes(5),
            ]);

            Log::info('OTP update result:', ['updated' => $updated, 'otp' => $otp, 'user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('OTP update error:', ['error' => $e->getMessage()]);
            return back()->withErrors(['email' => 'Something went wrong during 2FA setup']);
        }

        // Send OTP to email
        Mail::raw("Your 2FA OTP: {$otp}\n\nValid for 5 minutes.", function($msg) use ($user) {
            $msg->to($user->email)->subject('2FA Verification Code');
        });

        Log::info('OTP email sent to:', ['email' => $user->email]);

        return redirect()->route('2fa.show')->with('success', 'OTP sent to your email!');
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