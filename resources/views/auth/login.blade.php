<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: linear-gradient(180deg, #F5F5F0 0%, #E8E8E0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-container {
            display: flex;
            gap: 40px;
            max-width: 1000px;
            width: 100%;
            align-items: center;
        }

        .login-visual {
            flex: 1;
            display: none;
        }

        @media (min-width: 900px) {
            .login-visual {
                display: block;
            }

            .login-container {
                flex-direction: row;
            }
        }

        .login-box {
            flex: 1;
            border: 4px solid #000;
            padding: 48px 40px;
            background: #F5F5F0;
            box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.1);
        }

        .logo-section {
            margin-bottom: 40px;
        }

        .logo-section h1 {
            font-size: 36px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: -1px;
            color: #000;
        }

        .logo-section p {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            margin-bottom: 10px;
            color: #000;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 3px solid #000;
            background: #fff;
            color: #000;
            font-size: 15px;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            transition: all 0.2s;
        }

        .form-group input::placeholder {
            color: #ccc;
        }

        .form-group input:focus {
            outline: none;
            border-color: #FF8C00;
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.1);
        }

        .error-message {
            color: #D32F2F;
            font-size: 11px;
            margin-top: 6px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 28px;
            gap: 10px;
            font-size: 13px;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            border: 2px solid #000;
            background: #fff;
            accent-color: #FF8C00;
        }

        .remember-me label {
            margin: 0;
            font-weight: normal;
            text-transform: none;
            letter-spacing: 0;
            color: #000;
            cursor: pointer;
        }

        .btn {
            width: 100%;
            padding: 14px 20px;
            background: #FF8C00;
            color: #fff;
            border: 3px solid #FF8C00;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Courier New', monospace;
            transition: all 0.2s;
            margin-bottom: 0;
        }

        .btn:hover {
            background: #fff;
            color: #FF8C00;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #FF8C00;
        }

        .btn:active {
            transform: translate(0, 0);
        }

        .links {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 11px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 2px solid #E0E0E0;
        }

        .links a {
            color: #FF8C00;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.2s;
        }

        .links a:hover {
            color: #000;
            text-decoration: underline;
        }

        .alert {
            border: 3px solid #D32F2F;
            background: #FFEBEE;
            color: #D32F2F;
            padding: 14px;
            margin-bottom: 24px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .alert-success {
            border-color: #4CAF50;
            background: #E8F5E9;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-visual">
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 20px;">📁</div>
                <h2 style="font-size: 32px; font-weight: 900; margin-bottom: 10px; font-family: 'Courier New', monospace;">DMS</h2>
                <p style="color: #666; font-size: 14px; margin-bottom: 40px;">Secure Document Management</p>
                
                <div style="background: #FFE4B5; border: 3px solid #000; padding: 24px; margin-bottom: 24px;">
                    <p style="font-size: 13px; font-weight: 700; margin-bottom: 8px; text-transform: uppercase;">Features</p>
                    <ul style="list-style: none; font-size: 12px; text-align: left; color: #333;">
                        <li style="margin: 8px 0;">✓ File Encryption</li>
                        <li style="margin: 8px 0;">✓ 2FA Verification</li>
                        <li style="margin: 8px 0;">✓ Audit Logging</li>
                        <li style="margin: 8px 0;">✓ RBAC Access</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="login-box">
            <div class="logo-section">
                <h1>Login</h1>
                <p>Welcome back</p>
            </div>

            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn">Login</button>

                <div class="links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Create new account</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</body>
</html>