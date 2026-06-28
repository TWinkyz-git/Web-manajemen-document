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
            font-family: 'Courier New', monospace;
            background: #fff;
            color: #000;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        header {
            background: #fff;
            border-bottom: 4px solid #000;
            padding: 24px 0;
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -1px;
            text-transform: uppercase;
            color: #000;
        }

        nav {
            display: flex;
            gap: 32px;
            margin-top: 20px;
        }

        nav a {
            color: #FF8C00;
            text-decoration: none;
            font-weight: 700;
            border-bottom: 3px solid transparent;
            padding-bottom: 4px;
            transition: all 0.2s;
        }

        nav a:hover {
            border-bottom-color: #FF8C00;
            transform: translate(0, -2px);
        }

        nav button {
            color: #FF8C00;
            font-weight: 700;
            border-bottom: 3px solid transparent;
            padding-bottom: 4px;
            transition: all 0.2s;
        }

        nav button:hover {
            border-bottom-color: #FF8C00;
            transform: translate(0, -2px);
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #FF8C00;
            color: #fff;
            border: 3px solid #FF8C00;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            font-family: 'Courier New', monospace;
        }

        .btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #FF8C00;
            background: #fff;
            color: #FF8C00;
        }

        .btn-secondary {
            background: transparent;
            border: 3px solid #000;
            color: #000;
        }

        .btn-secondary:hover {
            background: #000;
            color: #fff;
            box-shadow: 4px 4px 0 #000;
        }

        .alert {
            padding: 16px;
            margin-bottom: 20px;
            border: 3px solid;
            font-weight: 600;
        }

        .alert-success {
            background: #E8F5E9;
            border-color: #4CAF50;
            color: #2E7D32;
        }

        .alert-error {
            background: #FFEBEE;
            border-color: #D32F2F;
            color: #D32F2F;
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
                <a href="{{ route('categories.index') }}">Categories</a>
                <a href="{{ route('audit-logs.index') }}">Logs</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; font-weight: 700; font-family: 'Courier New', monospace;">Logout</button>
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