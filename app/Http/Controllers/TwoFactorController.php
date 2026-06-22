<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.two-factor-challenge');
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $userId = auth()->id();
        $user = User::find($userId);

        Log::info('2FA verify attempt:', ['user_id' => $userId, 'user_otp' => $user->two_factor_otp, 'input_otp' => $validated['otp'], 'expires_at' => $user->two_factor_otp_expires_at]);

        if (!$user->two_factor_otp || $user->two_factor_otp_expires_at < now()) {
            Log::warning('OTP invalid or expired');
            return back()->withErrors(['otp' => 'OTP expired or invalid.']);
        }

        if ($user->two_factor_otp != $validated['otp']) {
            Log::warning('OTP mismatch:', ['expected' => $user->two_factor_otp, 'got' => $validated['otp']]);
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        $user->update([
            'two_factor_otp' => null,
            'two_factor_otp_expires_at' => null,
        ]);

        session(['2fa_verified' => true]);

        return redirect()->intended('/dashboard')->with('success', '2FA verification successful!');
    }
    public function resend(Request $request)
    {
        $user = auth()->user();
        
        $otp = rand(100000, 999999);
        
        $user->update([
            'two_factor_otp' => $otp,
            'two_factor_otp_expires_at' => now()->addMinutes(5),
        ]);

        Mail::raw("Your OTP: {$otp}\n\nValid for 5 minutes.", function($msg) use ($user) {
            $msg->to($user->email)->subject('2FA Verification Code');
        });

        return back()->with('success', 'OTP resent to your email!');
    }
}