<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #000;
            color: #fff;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        header {
            border-bottom: 3px solid #fff;
            padding: 24px 0;
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        nav {
            display: flex;
            gap: 32px;
            margin-top: 20px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            border-bottom: 3px solid transparent;
            padding-bottom: 4px;
            transition: border-color 0.2s;
        }

        nav a:hover {
            border-bottom-color: #fff;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #fff;
            color: #000;
            border: none;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s;
        }

        .btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 rgba(255, 255, 255, 0.3);
        }

        .btn-secondary {
            background: transparent;
            border: 3px solid #fff;
            color: #fff;
        }

        .alert {
            padding: 16px;
            margin-bottom: 20px;
            border: 3px solid;
            font-weight: 600;
        }

        .alert-success {
            background: #000;
            border-color: #00ff00;
            color: #00ff00;
        }

        .alert-error {
            background: #000;
            border-color: #ff0000;
            color: #ff0000;
        }

        main {
            margin-bottom: 60px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>📁 DMS</h1>
            <nav>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('documents.index') }}">Documents</a>
                <a href="#">Categories</a>
                <a href="#">Logs</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #fff; cursor: pointer; font-weight: 700; text-decoration: underline;">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>