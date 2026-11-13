<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Antrian Kendaraan</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --app-bg-gradient: linear-gradient(180deg, #dbeafe 0%, #ebf5ff 45%, #f4f9ff 100%);
            --primary-blue: #2563eb;
            --primary-gradient: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--app-bg-gradient);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            padding: 1.5rem;
            color: #0f172a;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(191, 219, 254, 0.6);
            box-shadow: 0 20px 45px -10px rgba(59, 130, 246, 0.12), 0 10px 20px -5px rgba(59, 130, 246, 0.05);
            overflow: hidden;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            padding: 2.25rem 2rem 1.25rem;
            text-align: center;
            background: #ffffff;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.25rem;
            border-radius: 18px;
            background: var(--primary-gradient);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        .login-header h3 {
            color: #0f172a;
            margin: 0;
            font-weight: 800;
            font-size: 1.45rem;
            letter-spacing: -0.02em;
        }

        .login-header p {
            color: #64748b;
            margin: 0.4rem 0 0;
            font-size: 0.9rem;
        }

        .login-body {
            padding: 1.5rem 2rem 2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.88rem;
            color: #334155;
            margin-bottom: 0.45rem;
        }

        .form-control {
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            color: #0f172a;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .input-group-text {
            background-color: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px 0 0 12px;
            color: #64748b;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            color: #ffffff;
            font-weight: 700;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            font-size: 0.98rem;
            min-height: 48px;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.28);
            transition: all 0.2s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #0284c7 0%, #1d4ed8 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.38);
        }

        .demo-box {
            background: #eff6ff;
            border: 1px dashed #93c5fd;
            border-radius: 14px;
            padding: 0.85rem 1rem;
            font-size: 0.83rem;
            color: #1e40af;
            margin-bottom: 1.5rem;
        }

        .demo-box strong {
            color: #1d4ed8;
        }

        .login-footer {
            text-align: center;
            padding: 0 2rem 2rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .login-footer a {
            color: var(--primary-blue);
            font-weight: 600;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="brand-icon">
                <i class="fas fa-truck-moving"></i>
            </div>
            <h3>Antrian Kendaraan</h3>
            <p>Masuk untuk mengelola data dan tiket antrian</p>
        </div>
        <div class="login-body">
            @if($errors->any())
                <div class="alert alert-danger py-2 border-0 shadow-sm mb-3" style="background:#fee2e2; color:#991b1b; border-radius:12px; font-size:0.875rem;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="demo-box">
                <div class="fw-bold mb-1"><i class="fas fa-key me-1"></i> Akun Demo Tersedia:</div>
                <div>Email: <strong>admin@antrian.com</strong></div>
                <div>Password: <strong>admin1234</strong></div>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Pengguna</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', 'admin@antrian.com') }}" placeholder="nama@email.com" required autofocus style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password Anda" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
                </button>
            </form>
        </div>
        <div class="login-footer">
            <p class="mb-0">Belum memiliki akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>
    </div>
</body>
</html>

