<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMS - Document Management System</title>
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
            color: #000;
        }

        header {
            border-bottom: 4px solid #000;
            padding: 24px 0;
            background: #F5F5F0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 32px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: #000;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            border-bottom: 3px solid transparent;
            padding-bottom: 4px;
            transition: all 0.2s;
        }

        .nav-links a:hover {
            border-bottom-color: #FF8C00;
            color: #FF8C00;
        }

        .btn-nav {
            background: #FF8C00;
            color: #fff;
            border: 3px solid #FF8C00;
            padding: 10px 20px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-nav:hover {
            background: #fff;
            color: #FF8C00;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #FF8C00;
        }

        .hero {
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 64px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 16px;
            letter-spacing: -2px;
            line-height: 1.1;
        }

        .hero p {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #FF8C00;
            color: #fff;
            border: 3px solid #FF8C00;
            padding: 16px 32px;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #fff;
            color: #FF8C00;
            transform: translate(-3px, -3px);
            box-shadow: 5px 5px 0 #FF8C00;
        }

        .btn-secondary {
            background: transparent;
            color: #000;
            border: 3px solid #000;
            padding: 16px 32px;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #000;
            color: #fff;
            transform: translate(-3px, -3px);
            box-shadow: 5px 5px 0 #000;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
            margin: 80px 0;
        }

        .feature-card {
            border: 4px solid #000;
            padding: 32px;
            background: #F5F5F0;
            box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
        }

        .feature-card:hover {
            transform: translate(-4px, -4px);
            box-shadow: 10px 10px 0 rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .feature-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }

        footer {
            border-top: 4px solid #000;
            padding: 40px 0;
            margin-top: 80px;
            background: #F5F5F0;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">📁 DMS</div>
                <div class="nav-links">
                    <a href="#features">Features</a>
                    <a href="#about">About</a>
                    <a href="{{ route('login') }}" class="btn-nav">Login</a>
                    <a href="{{ route('register') }}" class="btn-nav" style="background: #fff; color: #FF8C00; border-color: #FF8C00;">Register</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <section class="hero">
                <h1>Secure Document<br>Management System</h1>
                <p>Manage, encrypt, and audit your documents with enterprise-grade security and ease of use.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                    <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
                </div>
            </section>

            <section id="features" class="features">
                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <h3>File Encryption</h3>
                    <p>All documents are encrypted using AES-256-GCM encryption. Your files are secure at rest and in transit.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔑</div>
                    <h3>2FA Security</h3>
                    <p>Two-factor authentication via email OTP ensures only authorized users can access your account.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Audit Logging</h3>
                    <p>Every action is logged with timestamps, user info, and IP addresses for complete accountability.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>RBAC Access</h3>
                    <p>Role-based access control with granular permissions. Admin, Manager, and Staff roles.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📁</div>
                    <h3>Document Management</h3>
                    <p>Organize documents by categories, add descriptions, and manage permissions per document.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👁️</div>
                    <h3>Preview Documents</h3>
                    <p>View PDF and image files directly in your browser without downloading.</p>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Document Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>