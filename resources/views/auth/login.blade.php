<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-robot.png') }}?v=1.1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo-robot.png') }}?v=1.1">
    <title>Login - Smart IoT</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-main: #050505;
            --bg-card: #121212;
            --text-main: #ffffff;
            --text-muted: #a0a0a0;
            --accent-cyan: #00f2ff;
            --accent-purple: #b026ff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            /* UPDATE: Pakai min-height agar bisa discroll jika layar pendek */
            min-height: 100vh; 
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px 0; /* Jarak aman atas bawah */
        }

        /* --- BACKGROUND EFFECTS --- */
        .glow-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100vh;
            z-index: -1;
            background: 
                radial-gradient(circle at 10% 20%, rgba(0, 242, 255, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(176, 38, 255, 0.1) 0%, transparent 40%);
        }

        /* --- LOGIN CARD --- */
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: rgba(20, 20, 20, 0.8); /* Lebih gelap */
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.6);
            position: relative;
        }
        
        /* Garis Neon Top */
        .login-card::before {
            content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 50%; height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-cyan), transparent);
            box-shadow: 0 0 15px var(--accent-cyan);
        }

        .brand-logo { font-size: 26px; font-weight: 700; color: var(--text-main); margin-bottom: 5px; }
        .brand-logo i { color: var(--accent-cyan); }
        .login-subtitle { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 30px; }

        /* --- FORM INPUTS (FIXED COLORS) --- */
        .form-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        /* UPDATE: Input field dibuat gelap total agar tidak nabrak background */
        .form-control {
            background-color: #1a1a1a !important; /* Warna Gelap */
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff !important; /* Teks Putih */
            padding: 12px 15px;
            border-radius: 0 10px 10px 0; /* Rounded kanan */
        }
        
        .form-control:focus {
            background-color: #222 !important;
            border-color: var(--accent-cyan);
            color: #ffffff !important;
            box-shadow: none; /* Hilangkan shadow biru bawaan bootstrap */
        }
        
        /* Ikon di samping input */
        .input-group-text {
            background-color: #1a1a1a !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-right: none;
            color: var(--text-muted);
            border-radius: 10px 0 0 10px; /* Rounded kiri */
        }

        /* Placeholder warnanya abu, bukan putih */
        ::placeholder { color: #555 !important; opacity: 1; }

        /* --- BUTTONS --- */
        .btn-primary {
            background: var(--accent-cyan);
            border: none;
            color: #000; /* Teks hitam biar kontras dengan cyan */
            font-weight: 700;
            padding: 12px;
            border-radius: 50px;
            width: 100%;
            margin-top: 15px;
            transition: 0.3s;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.3);
        }
        .btn-primary:hover {
            background: #fff;
            color: #000;
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.6);
            transform: translateY(-2px);
        }

        .btn-google {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 10px;
            border-radius: 50px;
            width: 100%;
            display: block;
            text-align: center;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .btn-google:hover {
            border-color: #ff3366;
            background: rgba(255, 51, 102, 0.1);
            color: white;
        }

        /* --- EXTRAS --- */
        .form-check-label { color: var(--text-muted); font-size: 0.9rem; }
        .form-check-input { background-color: #333; border-color: #444; }
        .form-check-input:checked { background-color: var(--accent-cyan); border-color: var(--accent-cyan); }
        
        .forgot-link { color: var(--text-muted); font-size: 0.85rem; text-decoration: none; }
        .forgot-link:hover { color: var(--accent-cyan); }

        .divider { margin: 25px 0; color: rgba(255,255,255,0.2); font-size: 0.8rem; display: flex; align-items: center; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .divider::before { margin-right: 10px; } .divider::after { margin-left: 10px; }
    </style>
</head>
<body>

    <div class="glow-bg"></div>

    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="login-card">
                
                <div class="text-center">
                    <div class="brand-logo"><i class="fas fa-robot"></i> SmartIoT</div>
                    <p class="login-subtitle">Welcome back, Commander!</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small bg-danger bg-opacity-25 border-0 text-white mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="user@gmail.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">Ingat Saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">Lupa Password</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">LOGIN</button>

                    <div class="divider">ATAU</div>

                    <a href="{{ route('google.login') }}" class="btn btn-google">
                        <i class="fab fa-google me-2"></i> Google Account
                    </a>

                    <div class="text-center mt-4">
                        <!-- <span class="text-muted small">New user? </span> -->
                        <a href="{{ route('register') }}" class="text-info text-decoration-none small fw-bold">Buat Akun</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
</html>