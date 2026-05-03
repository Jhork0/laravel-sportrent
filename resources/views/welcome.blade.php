<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportRent — Canchas deportivas en Montería</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=barlow-condensed:700,800,900|barlow:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* ── Reset & base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:  #22c55e;
            --green2: #16a34a;
            --dark:   #0a0f0d;
            --dark2:  #111812;
            --card:   #141a15;
            --muted:  #6b7a6e;
            --white:  #f0f5f1;
            --font-display: 'Barlow Condensed', sans-serif;
            --font-body:    'Barlow', sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--dark);
            color: var(--white);
            font-family: var(--font-body);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Animated field lines background ── */
        .field-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }
        .field-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% 0%, rgba(34,197,94,0.07) 0%, transparent 70%),
                radial-gradient(ellipse 40% 40% at 80% 80%, rgba(34,197,94,0.04) 0%, transparent 60%);
        }

        /* SVG field lines */
        .field-lines {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0.04;
        }

        /* Noise grain texture */
        .grain {
            position: fixed;
            inset: -50%;
            width: 200%;
            height: 200%;
            z-index: 1;
            pointer-events: none;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
            animation: grain-move 8s steps(1) infinite;
        }
        @keyframes grain-move {
            0%,100%{transform:translate(0,0)}
            10%{transform:translate(-2%,-3%)}
            20%{transform:translate(3%,2%)}
            30%{transform:translate(-1%,4%)}
            40%{transform:translate(4%,-1%)}
            50%{transform:translate(-3%,3%)}
            60%{transform:translate(2%,-4%)}
            70%{transform:translate(-4%,1%)}
            80%{transform:translate(1%,3%)}
            90%{transform:translate(3%,-2%)}
        }

        /* ── Layout ── */
        .page-wrap {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ── */
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2.5rem;
            border-bottom: 1px solid rgba(34,197,94,0.08);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }
        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--green);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .logo-text {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .logo-text span { color: var(--green); }

        .nav-links { display: flex; align-items: center; gap: 0.75rem; }

        .btn-ghost {
            padding: 0.5rem 1.25rem;
            border: 1px solid rgba(240,245,241,0.15);
            border-radius: 8px;
            background: transparent;
            color: var(--white);
            font-family: var(--font-body);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: border-color 0.2s, background 0.2s;
            cursor: pointer;
        }
        .btn-ghost:hover {
            border-color: var(--green);
            background: rgba(34,197,94,0.06);
        }

        .btn-primary {
            padding: 0.5rem 1.25rem;
            background: var(--green);
            border: 1px solid var(--green);
            border-radius: 8px;
            color: #071008;
            font-family: var(--font-body);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: var(--green2);
            transform: translateY(-1px);
        }

        /* ── Hero ── */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 5rem 2rem 4rem;
            gap: 2rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.25);
            border-radius: 100px;
            padding: 0.35rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--green);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            animation: fade-up 0.6s ease both;
        }
        .hero-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%,100%{ opacity:1; transform:scale(1); }
            50%{ opacity:0.5; transform:scale(1.4); }
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(4rem, 12vw, 9rem);
            font-weight: 900;
            line-height: 0.9;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            animation: fade-up 0.6s 0.1s ease both;
        }
        .hero-title .line-green { color: var(--green); }
        .hero-title .line-outline {
            -webkit-text-stroke: 2px var(--white);
            color: transparent;
        }

        .hero-sub {
            max-width: 480px;
            font-size: 1.05rem;
            line-height: 1.65;
            color: var(--muted);
            animation: fade-up 0.6s 0.2s ease both;
        }
        .hero-sub strong { color: var(--white); font-weight: 600; }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            animation: fade-up 0.6s 0.3s ease both;
        }

        .btn-hero {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 2rem;
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-hero:hover { transform: translateY(-2px); }

        .btn-hero-main {
            background: var(--green);
            color: #071008;
            box-shadow: 0 0 30px rgba(34,197,94,0.25);
        }
        .btn-hero-main:hover {
            background: var(--green2);
            box-shadow: 0 0 40px rgba(34,197,94,0.4);
        }

        .btn-hero-secondary {
            background: rgba(240,245,241,0.06);
            border: 1px solid rgba(240,245,241,0.15);
            color: var(--white);
        }
        .btn-hero-secondary:hover {
            background: rgba(240,245,241,0.1);
            border-color: rgba(240,245,241,0.3);
        }

        /* ── Stats strip ── */
        .stats-strip {
            display: flex;
            justify-content: center;
            gap: 0;
            border-top: 1px solid rgba(34,197,94,0.08);
            border-bottom: 1px solid rgba(34,197,94,0.08);
            animation: fade-up 0.6s 0.4s ease both;
        }

        .stat-item {
            flex: 1;
            max-width: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 1rem;
            border-right: 1px solid rgba(34,197,94,0.08);
        }
        .stat-item:last-child { border-right: none; }

        .stat-num {
            font-family: var(--font-display);
            font-size: 2.25rem;
            font-weight: 900;
            color: var(--green);
            line-height: 1;
        }
        .stat-label {
            font-size: 0.72rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 0.25rem;
        }

        /* ── Feature cards ── */
        .features {
            padding: 5rem 2rem;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
        }

        .section-tag {
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--green);
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 3.5rem;
        }
        .section-title span { color: var(--green); }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
        }

        .feature-card {
            background: var(--card);
            border: 1px solid rgba(34,197,94,0.08);
            border-radius: 20px;
            padding: 2rem;
            transition: border-color 0.25s, transform 0.25s;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--green), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .feature-card:hover {
            border-color: rgba(34,197,94,0.25);
            transform: translateY(-4px);
        }
        .feature-card:hover::before { opacity: 1; }

        .card-icon {
            width: 48px;
            height: 48px;
            background: rgba(34,197,94,0.12);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
            color: var(--green);
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 0.6rem;
            color: var(--white);
        }

        .card-desc {
            font-size: 0.9rem;
            line-height: 1.6;
            color: var(--muted);
        }

        /* ── Sport types strip ── */
        .sport-strip {
            padding: 3rem 2rem;
            border-top: 1px solid rgba(34,197,94,0.08);
            overflow: hidden;
        }

        .sport-scroll {
            display: flex;
            gap: 1rem;
            animation: marquee 20s linear infinite;
            width: max-content;
        }
        @keyframes marquee {
            0%{ transform: translateX(0); }
            100%{ transform: translateX(-50%); }
        }

        .sport-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border: 1px solid rgba(34,197,94,0.15);
            border-radius: 100px;
            font-family: var(--font-display);
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
            color: var(--muted);
            background: rgba(34,197,94,0.04);
        }
        .sport-pill i { color: var(--green); font-size: 0.85rem; }

        /* ── CTA bottom ── */
        .cta-section {
            padding: 5rem 2rem;
            text-align: center;
            border-top: 1px solid rgba(34,197,94,0.08);
        }

        .cta-box {
            max-width: 600px;
            margin: 0 auto;
            background: var(--card);
            border: 1px solid rgba(34,197,94,0.15);
            border-radius: 24px;
            padding: 3.5rem 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .cta-box::after {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(34,197,94,0.12), transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .cta-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 900;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 1rem;
        }
        .cta-title span { color: var(--green); }

        .cta-desc {
            font-size: 0.95rem;
            color: var(--muted);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .cta-btns {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ── Footer ── */
        footer {
            padding: 1.5rem 2.5rem;
            border-top: 1px solid rgba(34,197,94,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .footer-text {
            font-size: 0.8rem;
            color: var(--muted);
        }
        .footer-text a {
            color: var(--green);
            text-decoration: none;
        }
        .footer-version {
            font-family: monospace;
            font-size: 0.75rem;
            color: rgba(107,122,110,0.5);
            background: rgba(34,197,94,0.05);
            border: 1px solid rgba(34,197,94,0.08);
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
        }

        /* ── Animations ── */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media(max-width: 640px) {
            nav { padding: 1.25rem 1.25rem; }
            .features { padding: 3rem 1.25rem; }
            .hero { padding: 3.5rem 1.25rem 3rem; }
            .hero-title .line-outline { -webkit-text-stroke-width: 1.5px; }
            .stats-strip { gap: 0; }
            .stat-item { max-width: none; }
            footer { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

    {{-- Fondo decorativo (campo de fútbol abstracto) --}}
    <div class="field-bg">
        <svg class="field-lines" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <!-- Líneas del campo -->
            <rect x="100" y="80" width="1240" height="740" rx="8" fill="none" stroke="white" stroke-width="3"/>
            <line x1="720" y1="80" x2="720" y2="820" stroke="white" stroke-width="2"/>
            <circle cx="720" cy="450" r="100" fill="none" stroke="white" stroke-width="2"/>
            <circle cx="720" cy="450" r="5" fill="white"/>
            <!-- Área izq -->
            <rect x="100" y="270" width="160" height="360" fill="none" stroke="white" stroke-width="2"/>
            <rect x="100" y="345" width="60" height="210" fill="none" stroke="white" stroke-width="2"/>
            <circle cx="260" cy="450" r="3" fill="white"/>
            <!-- Área der -->
            <rect x="1180" y="270" width="160" height="360" fill="none" stroke="white" stroke-width="2"/>
            <rect x="1280" y="345" width="60" height="210" fill="none" stroke="white" stroke-width="2"/>
            <circle cx="1180" cy="450" r="3" fill="white"/>
            <!-- Esquinas -->
            <path d="M100,80 Q115,80 115,95" fill="none" stroke="white" stroke-width="2"/>
            <path d="M1340,80 Q1325,80 1325,95" fill="none" stroke="white" stroke-width="2"/>
            <path d="M100,820 Q115,820 115,805" fill="none" stroke="white" stroke-width="2"/>
            <path d="M1340,820 Q1325,820 1325,805" fill="none" stroke="white" stroke-width="2"/>
        </svg>
    </div>

    {{-- Grano de textura --}}
    <div class="grain"></div>

    <div class="page-wrap">

        {{-- Navegación --}}
        <nav>
            <a href="/" class="logo">
                <div class="logo-icon">⚽</div>
                <span class="logo-text">Sport<span>Rent</span></span>
            </a>

            @if (Route::has('login'))
                <div class="nav-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">
                            <i class="fas fa-th-large" style="font-size:0.8rem"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-ghost">Iniciar sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>

        {{-- Hero principal --}}
        <section class="hero">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Montería, Córdoba · Colombia
            </div>

            <h1 class="hero-title">
                <span class="line-green">Reserva</span><br>
                <span class="line-outline">tu cancha</span><br>
                <span>al instante</span>
            </h1>

            <p class="hero-sub">
                La plataforma líder para encontrar y reservar
                <strong>canchas deportivas</strong> en Montería.
                Fútbol, baloncesto, tenis y más — disponibles 24/7.
            </p>

            <div class="hero-cta">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-hero btn-hero-main">
                        <i class="fas fa-futbol"></i>
                        Reservar ahora
                    </a>
                @endif
                <a href="{{ route('login') }}" class="btn-hero btn-hero-secondary">
                    <i class="fas fa-sign-in-alt"></i>
                    Ya tengo cuenta
                </a>
            </div>
        </section>

        {{-- Stats strip --}}
        <div class="stats-strip">
            <div class="stat-item">
                <span class="stat-num">+40</span>
                <span class="stat-label">Canchas disponibles</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">24/7</span>
                <span class="stat-label">Reservas en línea</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">5★</span>
                <span class="stat-label">Valoración usuarios</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">6</span>
                <span class="stat-label">Deportes disponibles</span>
            </div>
        </div>

        {{-- Deportes en marquee --}}
        <div class="sport-strip">
            <div class="sport-scroll">
                {{-- Duplicado para efecto infinito --}}
                @foreach ([
                    ['icon'=>'fa-futbol',        'label'=>'Fútbol'],
                    ['icon'=>'fa-circle',         'label'=>'Microfútbol'],
                    ['icon'=>'fa-basketball-ball','label'=>'Baloncesto'],
                    ['icon'=>'fa-baseball-ball',  'label'=>'Béisbol'],
                    ['icon'=>'fa-volleyball-ball','label'=>'Voleibol'],
                    ['icon'=>'fa-table-tennis',   'label'=>'Tenis de mesa'],
                    ['icon'=>'fa-futbol',         'label'=>'Fútsal'],
                    ['icon'=>'fa-swimmer',        'label'=>'Natación'],
                    ['icon'=>'fa-futbol',        'label'=>'Fútbol'],
                    ['icon'=>'fa-circle',         'label'=>'Microfútbol'],
                    ['icon'=>'fa-basketball-ball','label'=>'Baloncesto'],
                    ['icon'=>'fa-baseball-ball',  'label'=>'Béisbol'],
                    ['icon'=>'fa-volleyball-ball','label'=>'Voleibol'],
                    ['icon'=>'fa-table-tennis',   'label'=>'Tenis de mesa'],
                    ['icon'=>'fa-futbol',         'label'=>'Fútsal'],
                    ['icon'=>'fa-swimmer',        'label'=>'Natación'],
                ] as $sport)
                    <div class="sport-pill">
                        <i class="fas {{ $sport['icon'] }}"></i>
                        {{ $sport['label'] }}
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Features --}}
        <section class="features">
            <p class="section-tag">¿Por qué SportRent?</p>
            <h2 class="section-title">Todo lo que<br><span>necesitas</span></h2>

            <div class="cards-grid">
                <div class="feature-card">
                    <div class="card-icon"><i class="fas fa-search-location"></i></div>
                    <h3 class="card-title">Encuentra rápido</h3>
                    <p class="card-desc">Busca canchas por tipo de deporte, ubicación o precio. Toda la oferta deportiva de Montería en un solo lugar.</p>
                </div>

                <div class="feature-card">
                    <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
                    <h3 class="card-title">Reserva en segundos</h3>
                    <p class="card-desc">Selecciona fecha, hora y cancha. Sin llamadas, sin filas. Tu reserva queda confirmada al instante.</p>
                </div>

                <div class="feature-card">
                    <div class="card-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3 class="card-title">100% seguro</h3>
                    <p class="card-desc">Todas las canchas están verificadas. Tu pago y tus datos están protegidos en todo momento.</p>
                </div>

                <div class="feature-card">
                    <div class="card-icon"><i class="fas fa-star"></i></div>
                    <h3 class="card-title">Reseñas reales</h3>
                    <p class="card-desc">Lee las opiniones de otros deportistas antes de reservar. Valoraciones honestas de la comunidad.</p>
                </div>

                <div class="feature-card">
                    <div class="card-icon"><i class="fas fa-mobile-alt"></i></div>
                    <h3 class="card-title">Siempre disponible</h3>
                    <p class="card-desc">Accede desde cualquier dispositivo. Gestiona tus reservas cuando y donde quieras, 24 horas al día.</p>
                </div>

                <div class="feature-card">
                    <div class="card-icon"><i class="fas fa-tags"></i></div>
                    <h3 class="card-title">Mejores precios</h3>
                    <p class="card-desc">Compara precios y encuentra la mejor opción para tu equipo. Sin costos ocultos ni sorpresas.</p>
                </div>
            </div>
        </section>

        {{-- CTA final --}}
        <section class="cta-section">
            <div class="cta-box">
                <h2 class="cta-title">¿Listo para<br><span>jugar?</span></h2>
                <p class="cta-desc">
                    Únete a cientos de deportistas que ya usan SportRent
                    para reservar su cancha en Montería.
                </p>
                <div class="cta-btns">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-hero btn-hero-main">
                            <i class="fas fa-user-plus"></i>
                            Crear cuenta gratis
                        </a>
                    @endif
                    <a href="{{ route('login') }}" class="btn-hero btn-hero-secondary">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer>
            <p class="footer-text">
                © {{ date('Y') }} <strong style="color:var(--white)">SportRent</strong> ·
                Hecho con <span style="color:var(--green)">♥</span> en Montería, Colombia ·
                <a href="https://laravel.com" target="_blank">Laravel</a>
            </p>
            <span class="footer-version">v{{ app()->version() }}</span>
        </footer>

    </div>{{-- .page-wrap --}}

</body>
</html>