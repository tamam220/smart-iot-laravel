<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-robot.png') }}?v=1.1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo-robot.png') }}?v=1.1">
    <title>Reset Password - Smart IoT</title>

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
            --accent-yellow: #fcd34d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px;
        }

        /* --- BACKGROUND GLOW --- */
        .glow-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100vh;
            z-index: -1;
            background: 
                radial-gradient(circle at 50% 10%, rgba(176, 38, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 10% 90%, rgba(0, 242, 255, 0.1) 0%, transparent 40%);
        }

        /* --- CARD DESIGN --- */
        .reset-card {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background: rgba(20, 20, 20, 0.85);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.7);
            position: relative;
            text-align: center;
        }
        
        /* Garis Neon Top (Kuning/Warning style untuk reset password) */
        .reset-card::before {
            content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 50%; height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-yellow), transparent);
            box-shadow: 0 0 15px var(--accent-yellow);
        }

        .brand-logo { font-size: 26px; font-weight: 700; color: var(--text-main); margin-bottom: 20px; display: block;}
        .brand-logo i { color: var(--accent-cyan); }
        
        .description-text {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* --- FORM INPUTS --- */
        .form-label { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; text-align: left; display: block;}

        .form-control {
            background-color: #1a1a1a !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff !important;
            padding: 12px 15px;
            border-radius: 0 10px 10px 0;
        }
        
        .form-control:focus {
            background-color: #222 !important;
            border-color: var(--accent-yellow); /* Kuning saat fokus */
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
            background: linear-gradient(135deg, var(--accent-yellow), #f59e0b);
            border: none;
            color: #000;
            font-weight: 700;
            padding: 12px;
            border-radius: 50px;
            width: 100%;
            margin-top: 20px;
            transition: 0.3s;
            box-shadow: 0 0 20px rgba(252, 211, 77, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(252, 211, 77, 0.5);
            background: #fff;
            color: #000;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .back-link:hover { color: var(--text-main); }

        /* --- ALERTS (CUSTOM DARK) --- */
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #34d399;
            font-size: 0.85rem;
            border-radius: 10px;
        }
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
            font-size: 0.85rem;
            border-radius: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="glow-bg"></div>

    <div class="reset-card">
        
        <div class="brand-logo"><i class="fas fa-robot"></i> SmartIoT</div>

        <div class="description-text">
            Lupa password? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password.
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="user@gmail.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                KIRIM LINK RESET
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
        </a>

    </div>

</body>
</html>