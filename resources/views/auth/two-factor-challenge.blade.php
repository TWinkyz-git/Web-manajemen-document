@extends('layouts.auth')

@section('title', '2FA Verification')

@section('content')
<div style="max-width: 500px;">
    <div style="border: 4px solid #000; padding: 48px 40px; background: #F5F5F0; box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 36px; font-weight: 900; text-transform: uppercase; margin-bottom: 12px; letter-spacing: -1px;">2FA</h2>
        <p style="color: #666; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 3px solid #FF8C00;">Verification Code</p>

        <p style="color: #666; font-size: 14px; margin-bottom: 32px; line-height: 1.6;">
            Enter the 6-digit code sent to your email address
        </p>

        @if ($errors->any())
            <div style="background: #FFEBEE; border: 3px solid #D32F2F; color: #D32F2F; padding: 12px; margin-bottom: 24px; font-weight: 700; font-size: 11px; text-transform: uppercase;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}" style="display: grid; gap: 24px;">
            @csrf

            <div>
                <input type="text" 
                       name="otp" 
                       maxlength="6" 
                       placeholder="000000" 
                       required 
                       autofocus
                       style="width: 100%; padding: 16px; border: 3px solid #000; background: #fff; color: #000; font-size: 32px; text-align: center; letter-spacing: 8px; font-weight: 900; font-family: 'Courier New', monospace; transition: all 0.2s;"
                       onfocus="this.style.borderColor='#FF8C00'; this.style.boxShadow='0 0 0 3px rgba(255, 140, 0, 0.1)';"
                       onblur="this.style.borderColor='#000'; this.style.boxShadow='';">
                @error('otp')
                    <span style="color: #D32F2F; font-size: 11px; margin-top: 6px; display: block; font-weight: 700; text-transform: uppercase;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" style="width: 100%; padding: 14px 20px; background: #FF8C00; color: #fff; border: 3px solid #FF8C00; font-weight: 800; font-size: 13px; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; font-family: 'Courier New', monospace; transition: all 0.2s;" onmouseover="this.style.background='#fff'; this.style.color='#FF8C00'; this.style.transform='translate(-2px, -2px)'; this.style.boxShadow='4px 4px 0 #FF8C00';" onmouseout="this.style.background='#FF8C00'; this.style.color='#fff'; this.style.transform='translate(0, 0)'; this.style.boxShadow='';">Verify</button>
        </form>

        <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 2px solid #E0E0E0;">
            <form method="POST" action="{{ route('2fa.resend') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; padding: 12px 20px; background: transparent; color: #000; border: 3px solid #000; font-weight: 800; font-size: 12px; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; font-family: 'Courier New', monospace; transition: all 0.2s;" onmouseover="this.style.background='#000'; this.style.color='#fff'; this.style.transform='translate(-2px, -2px)'; this.style.boxShadow='4px 4px 0 #000';" onmouseout="this.style.background='transparent'; this.style.color='#000'; this.style.transform='translate(0, 0)'; this.style.boxShadow='';">Resend Code</button>
            </form>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; padding: 12px 20px; background: #D32F2F; color: #fff; border: 3px solid #D32F2F; font-weight: 800; font-size: 12px; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; font-family: 'Courier New', monospace; transition: all 0.2s;" onmouseover="this.style.background='#fff'; this.style.color='#D32F2F'; this.style.transform='translate(-2px, -2px)'; this.style.boxShadow='4px 4px 0 #D32F2F';" onmouseout="this.style.background='#D32F2F'; this.style.color='#fff'; this.style.transform='translate(0, 0)'; this.style.boxShadow='';">Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection