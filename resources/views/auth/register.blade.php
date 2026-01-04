<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-robot.png') }}?v=1.1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo-robot.png') }}?v=1.1">
    <title>Register - Smart IoT</title>

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
            /* PENTING: Agar bisa discroll dan tidak kepotong */
            min-height: 100vh; 
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 40px 0; /* Jarak aman atas bawah lebih besar untuk register */
        }

        /* --- BACKGROUND EFFECTS --- */
        .glow-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100vh;
            z-index: -1;
            background: 
                radial-gradient(circle at 80% 10%, rgba(0, 242, 255, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 20% 90%, rgba(176, 38, 255, 0.1) 0%, transparent 40%);
        }

        /* --- REGISTER CARD --- */
        .register-card {
            width: 100%;
            max-width: 450px; /* Sedikit lebih lebar dari login */
            padding: 40px;
            background: rgba(20, 20, 20, 0.85);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.6);
            position: relative;
        }
        
        /* Garis Neon Top */
        .register-card::before {
            content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 60%; height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-purple), transparent);
            box-shadow: 0 0 15px var(--accent-purple);
        }

        .brand-logo { font-size: 26px; font-weight: 700; color: var(--text-main); margin-bottom: 5px; }
        .brand-logo i { color: var(--accent-cyan); }
        .register-subtitle { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 25px; }

        /* --- FORM INPUTS (DARK THEME) --- */
        .form-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .form-control {
            background-color: #1a1a1a !important; /* Gelap */
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff !important;
            padding: 12px 15px;
            border-radius: 0 10px 10px 0;
        }
        
        .form-control:focus {
            background-color: #222 !important;
            border-color: var(--accent-cyan);
            color: #ffffff !important;
            box-shadow: none;
        }
        
        .input-group-text {
            background-color: #1a1a1a !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-right: none;
            color: var(--text-muted);
            border-radius: 10px 0 0 10px;
            min-width: 45px;
            justify-content: center;
        }

        ::placeholder { color: #555 !important; opacity: 1; }

        /* --- BUTTONS --- */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-cyan), #00a8ff);
            border: none;
            color: #000;
            font-weight: 700;
            padding: 12px;
            border-radius: 50px;
            width: 100%;
            margin-top: 20px;
            transition: 0.3s;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.5);
            color: #000;
        }

        /* --- EXTRAS --- */
        .login-text {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .login-text a {
            color: var(--accent-cyan);
            text-decoration: none;
            font-weight: 600;
        }
        .login-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="glow-bg"></div>

    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="register-card">
                
                <div class="text-center">
                    <div class="brand-logo"><i class="fas fa-robot"></i> SmartIoT</div>
                    <p class="register-subtitle">Join the future of automation.</p>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" class="form-control" placeholder="Thamss" value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="user@gmail.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Buat Password" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Masukan Ulang Password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">BUAT AKUN</button>

                    <div class="login-text">
                        Sudah punya akun? <a href="{{ route('login') }}">Log In</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
</html>