<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: linear-gradient(180deg, #FFF8F0 0%, #F0F8FF 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .register-container {
            display: flex;
            gap: 40px;
            max-width: 1000px;
            width: 100%;
            align-items: center;
        }

        .register-visual {
            flex: 1;
            display: none;
        }

        @media (min-width: 900px) {
            .register-visual {
                display: block;
            }

            .register-container {
                flex-direction: row;
            }
        }

        .register-box {
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

        .form-group input {
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
            margin-bottom: 16px;
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
    <div class="register-container">
        <div class="register-visual">
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 20px;">📁</div>
                <h2 style="font-size: 32px; font-weight: 900; margin-bottom: 10px; font-family: 'Courier New', monospace;">Join DMS</h2>
                <p style="color: #666; font-size: 14px; margin-bottom: 40px;">Create your account now</p>
                
                <div style="background: #FFE4B5; border: 3px solid #000; padding: 24px; margin-bottom: 24px;">
                    <p style="font-size: 13px; font-weight: 700; margin-bottom: 12px; text-transform: uppercase;">Why join?</p>
                    <ul style="list-style: none; font-size: 12px; text-align: left; color: #333;">
                        <li style="margin: 8px 0;">✓ Secure file storage</li>
                        <li style="margin: 8px 0;">✓ Enterprise encryption</li>
                        <li style="margin: 8px 0;">✓ Team collaboration</li>
                        <li style="margin: 8px 0;">✓ Full audit trail</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="register-box">
            <div class="logo-section">
                <h1>Register</h1>
                <p>Create your account</p>
            </div>

            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Your full name">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password (min 12 chars, upper, lower, number, special)</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" required placeholder="••••••••" onkeyup="checkPasswordStrength()">
                        <button type="button" onclick="togglePasswordVisibility()" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 18px; padding: 0;">
                            <span id="toggle-icon">👁️</span>
                        </button>
                    </div>
                    <div id="password-strength" style="margin-top: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"></div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
                        <button type="button" onclick="toggleConfirmPasswordVisibility()" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 18px; padding: 0;">
                            <span id="toggle-confirm-icon">👁️</span>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn">Register</button>

                <div class="links">
                    <a href="{{ route('login') }}">Already have an account? Login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggle-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '🙈';
            } else {
                input.type = 'password';
                icon.textContent = '👁️';
            }
        }

        function toggleConfirmPasswordVisibility() {
            const input = document.getElementById('password_confirmation');
            const icon = document.getElementById('toggle-confirm-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '🙈';
            } else {
                input.type = 'password';
                icon.textContent = '👁️';
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthDiv = document.getElementById('password-strength');
            
            let strength = 0;
            let requirements = [];

            if (password.length >= 12) requirements.push(true); else requirements.push(false);
            if (/[A-Z]/.test(password)) requirements.push(true); else requirements.push(false);
            if (/[a-z]/.test(password)) requirements.push(true); else requirements.push(false);
            if (/[0-9]/.test(password)) requirements.push(true); else requirements.push(false);
            if (/[^A-Za-z0-9]/.test(password)) requirements.push(true); else requirements.push(false);

            strength = requirements.filter(r => r).length;

            if (password.length === 0) {
                strengthDiv.textContent = '';
                return;
            }

            let strengthText = '';
            let strengthColor = '';

            if (strength === 5) {
                strengthText = '✓ Strong password';
                strengthColor = '#4CAF50';
            } else if (strength >= 3) {
                strengthText = '⚠ Good password';
                strengthColor = '#FF9800';
            } else {
                strengthText = '✗ Weak password';
                strengthColor = '#D32F2F';
            }

            strengthDiv.textContent = strengthText;
            strengthDiv.style.color = strengthColor;
        }
    </script>
</body>
</html>