@extends('layouts.auth')

@section('title', '2FA Verification')

@section('content')
<div style="max-width: 500px;">
    <div style="border: 3px solid #fff; padding: 40px;">
        <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 32px; text-align: center;">2FA Verification</h2>

        <p style="color: #888; font-size: 14px; margin-bottom: 32px; text-align: center;">
            Enter the 6-digit code sent to your email
        </p>

        @if ($errors->any())
            <div style="background: #000; border: 3px solid #ff0000; color: #ff0000; padding: 12px; margin-bottom: 24px; font-weight: 600;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf

            <div style="margin-bottom: 24px;">
                <input type="text" 
                       name="otp" 
                       maxlength="6" 
                       placeholder="000000" 
                       required 
                       autofocus
                       style="width: 100%; padding: 16px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 32px; text-align: center; letter-spacing: 8px; font-weight: 900; font-family: monospace;">
                @error('otp')
                    <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 12px 24px; background: #fff; color: #000; border: none; font-weight: 700; font-size: 14px; cursor: pointer; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px;">Verify</button>
        </form>

        <form method="POST" action="{{ route('2fa.resend') }}">
            @csrf
            <button type="submit" style="width: 100%; padding: 12px 24px; background: transparent; color: #fff; border: 3px solid #fff; font-weight: 700; font-size: 14px; cursor: pointer; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;">Resend Code</button>
        </form>
    </div>
</div>
@endsection