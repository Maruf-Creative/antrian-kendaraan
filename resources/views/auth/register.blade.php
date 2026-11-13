<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Antrian Kendaraan</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --app-bg-gradient: linear-gradient(180deg, #dbeafe 0%, #ebf5ff 45%, #f8fafc 100%);
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
            padding: 2rem 1.5rem;
            color: #0f172a;
        }

        .register-card {
            width: 100%;
            max-width: 460px;
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

        .register-header {
            padding: 2.25rem 2rem 1rem;
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

        .register-header h3 {
            color: #0f172a;
            margin: 0;
            font-weight: 800;
            font-size: 1.45rem;
            letter-spacing: -0.02em;
        }

        .register-header p {
            color: #64748b;
            margin: 0.4rem 0 0;
            font-size: 0.9rem;
        }

        .register-body {
            padding: 1rem 2rem 2rem;
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
            padding: 0.68rem 1rem;
            font-size: 0.93rem;
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

        .btn-register {
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

        .btn-register:hover {
            background: linear-gradient(135deg, #0284c7 0%, #1d4ed8 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.38);
        }

        .register-footer {
            text-align: center;
            padding: 0 2rem 2rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .register-footer a {
            color: var(--primary-blue);
            font-weight: 600;
            text-decoration: none;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-header">
            <div class="brand-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h3>Registrasi Akun Baru</h3>
            <p>Mulai kelola armada dan antrian kendaraan Anda</p>
        </div>
        <div class="register-body">
            @if($errors->any())
                <div class="alert alert-danger py-2 border-0 shadow-sm mb-3" style="background:#fee2e2; color:#991b1b; border-radius:12px; font-size:0.875rem;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang password" required style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <button type="submit" class="btn-register">
                    <i class="fas fa-check-circle"></i> Buat Akun Sekarang
                </button>
            </form>
        </div>
        <div class="register-footer">
            <p class="mb-0">Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
        </div>
    </div>
</body>
</html>

