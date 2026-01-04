<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-robot.png') }}?v=1">
    <title>Smart IoT Platform</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --bg-main: #050505;
            --bg-card: #151515;       /* Card sedikit lebih terang */
            --text-main: #ffffff;
            --text-muted: #b0b0b0;    /* UPDATE: Text muted jadi abu TERANG */
            --accent-cyan: #00f2ff;
            --accent-pink: #ff0055;
            --accent-purple: #b026ff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .text-cyan-500 { color: #06b6d4 !important; }
        .bg-cyan-50 { background-color: #ecfeff !important; }

        /* --- GLOBAL OVERRIDES --- */
        /* Memaksa text-muted jadi terang supaya terbaca di background gelap */
        .text-muted { color: var(--text-muted) !important; }

        /* --- NAVBAR --- */
        .navbar {
            padding: 20px 0;
            background: rgba(5, 5, 5, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .navbar-brand { font-weight: 800; font-size: 24px; color: var(--text-main) !important; }
        .btn-nav { color: var(--text-main); font-weight: 500; padding: 8px 25px; border-radius: 50px; transition: 0.3s; }
        .btn-nav:hover { color: var(--accent-cyan); background: rgba(255,255,255,0.05); }
        .btn-login { border: 1px solid rgba(255,255,255,0.2); margin-right: 10px; }
        .btn-signup { background: var(--accent-cyan); color: #000; font-weight: 700; border: none; box-shadow: 0 0 15px rgba(0, 242, 255, 0.4); }
        .btn-signup:hover { background: #fff; box-shadow: 0 0 25px rgba(255, 255, 255, 0.6); color: #000; }

        /* --- HERO SECTION --- */
        .hero-section {
            padding: 120px 0 100px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero-title { font-size: 4rem; font-weight: 800; line-height: 1.1; margin-bottom: 25px; }
        @media (max-width: 768px) { .hero-title { font-size: 2.5rem; } } /* Fix mobile font */
        
        .text-gradient { background: linear-gradient(to right, var(--accent-cyan), var(--accent-purple)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { font-size: 1.2rem; color: var(--text-muted); margin-bottom: 40px; max-width: 90%; line-height: 1.8; }

        /* --- HOLOGRAM ANIMATION (PENGGANTI GAMBAR) --- */
        /* Ini adalah codingan murni CSS, jadi PASTI MUNCUL tanpa download gambar */
        .hologram-wrapper {
            position: relative;
            width: 300px; height: 300px;
            margin: 0 auto;
            display: flex; justify-content: center; align-items: center;
        }
        .holo-circle {
            position: absolute; border-radius: 50%; border: 2px solid transparent;
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.2);
        }
        .c1 { width: 100%; height: 100%; border-top: 4px solid var(--accent-cyan); border-bottom: 4px solid var(--accent-purple); animation: spin 8s linear infinite; }
        .c2 { width: 70%; height: 70%; border-left: 4px solid var(--accent-pink); border-right: 4px solid var(--accent-cyan); animation: spin 12s linear infinite reverse; }
        .c3 { width: 40%; height: 40%; border: 2px dashed rgba(255,255,255,0.5); animation: spin 5s linear infinite; }
        
        .holo-icon {
            font-size: 80px; color: var(--accent-cyan);
            filter: drop-shadow(0 0 20px var(--accent-cyan));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes spin { 100% { transform: rotate(360deg); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        /* --- FEATURES CARDS --- */
        .feature-card {
            background: var(--bg-card);
            border: 1px solid rgba(255,255,255,0.08); /* Border lebih tegas */
            border-radius: 20px; padding: 35px 30px; transition: 0.3s; height: 100%;
        }
        .feature-card:hover { 
            transform: translateY(-5px); 
            border-color: var(--accent-cyan); 
            box-shadow: 0 10px 30px -10px rgba(0, 242, 255, 0.15); 
            background: #1a1a1a;
        }
        .feature-icon {
            width: 60px; height: 60px; background: rgba(255,255,255,0.05); border-radius: 15px;
            display: flex; align-items: center; justify-content: center; font-size: 24px; color: var(--text-main); margin-bottom: 25px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .feature-card:hover .feature-icon { background: var(--accent-cyan); color: #000; box-shadow: 0 0 20px var(--accent-cyan); }
        
        /* Memastikan text di dalam card terbaca */
        .feature-card h4 { color: #fff; margin-bottom: 15px; }
        .feature-card p { color: var(--text-muted) !important; font-size: 0.95rem; line-height: 1.6; }

        footer { border-top: 1px solid rgba(255,255,255,0.1); padding: 40px 0; margin-top: 80px; color: var(--text-muted); text-align: center; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-robot me-2" style="color: var(--accent-cyan);"></i>SmartIoT
            </a>
            
            <div class="ms-auto d-flex align-items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-signup btn-nav">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-nav btn-login">Log In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-nav btn-signup">Sign Up</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-lg-6 pe-lg-5 text-center text-lg-start" data-aos="fade-right">
                    <span class="badge bg-dark border border-secondary text-info mb-3 px-3 py-2 rounded-pill">
                        <i class="fas fa-circle me-1" style="font-size:8px;"></i>SYSTEM ONLINE
                    </span>
                    <h1 class="hero-title">
                        Future IoT <br>
                        <span class="text-gradient">Control Center</span>
                    </h1>
                    <p class="hero-desc">
                        Kendalikan perangkat keras Anda dengan antarmuka Cyberpunk yang imersif. Koneksi real-time, data presisi, dan keamanan tingkat tinggi.
                    </p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                         @auth
                             <a href="{{ url('/dashboard') }}" class="btn btn-signup px-5 py-3 rounded-pill">Masuk Console</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-signup px-5 py-3 rounded-pill">Mulai Sekarang</a>
                            <!-- <a href="#features" class="btn btn-login px-4 py-3 rounded-pill">Pelajari</a> -->
                        @endauth
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0" data-aos="zoom-in">
                    <div class="hologram-wrapper">
                        <div class="holo-circle c1"></div>
                        <div class="holo-circle c2"></div>
                        <div class="holo-circle c3"></div>
                        <div class="holo-icon">
                            <i class="fas fa-microchip"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="features" class="pb-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-brain"></i></div>
                        <h4 class="fw-bold">Smart Core</h4>
                        <p class="small">Otak pemrosesan data cerdas yang menghubungkan ESP32/Arduino Anda dengan cloud server secara instan.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                        <h4 class="fw-bold">Instant Action</h4>
                        <p class="small">Latensi ultra-rendah. Perintah yang Anda kirim dieksekusi dalam hitungan milidetik tanpa delay.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-lock"></i></div>
                        <h4 class="fw-bold">Secure Link</h4>
                        <p class="small">Enkripsi data end-to-end memastikan token dan kontrol perangkat Anda tetap aman dari akses luar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p class="mb-2">&copy; 2025 Smart IoT Platform. Built for Future.</p>
            <div class="d-flex justify-content-center gap-4 mt-3">
                <a href="#" class="text-secondary text-decoration-none"><i class="fab fa-github"></i></a>
                <a href="https://www.instagram.com/_tamam22/" class="text-secondary text-decoration-none"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-secondary text-decoration-none"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
</body>
</html>