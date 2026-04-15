<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartInventory Pro</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Colores de Marca */
            --brand-primary: #00f2ff;    /* Cyan brillante */
            --brand-secondary: #0066ff;  /* Azul corporativo */
            --bg-dark: #0a192f;          /* Fondo azul muy oscuro */
            --bg-slate-50: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #e2e8f0;
            background: var(--bg-dark);
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, .font-display {
            font-family: 'Outfit', sans-serif;
            color: #fff;
        }

        /* Override Bootstrap text-secondary for dark theme */
        .text-secondary {
            color: #94a3b8 !important;
        }

        /* ---- Navbar ---- */
        .navbar-custom {
            background: rgba(10, 25, 47, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .navbar-brand-logo {
            width: 42px; height: 42px;
            background: var(--brand-secondary);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 15px rgba(0, 102, 255, 0.4);
        }
        .navbar-brand span { font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.25rem; }
        .nav-link-custom { color: #cbd5e1 !important; font-weight: 500; font-size: .9rem; transition: color .2s; }
        .nav-link-custom:hover { color: var(--brand-primary) !important; }
        .btn-login {
            color: #e2e8f0; font-weight: 600; font-size: .9rem;
            background: transparent; border: none;
            transition: color .2s;
        }
        .btn-login:hover { color: var(--brand-primary); }
        .btn-register-nav {
            background: var(--brand-secondary);
            color: #fff; font-weight: 600; font-size: .9rem;
            border-radius: 50px; padding: .55rem 1.4rem;
            border: none;
            transition: all .2s;
        }
        .btn-register-nav:hover { 
            background: var(--brand-primary); 
            color: var(--bg-dark); 
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.4); 
        }
        .btn-register-nav:active { transform: scale(.96); }

        /* ---- Hero ---- */
        .hero-section {
            padding-top: 9rem;
            padding-bottom: 5rem;
            position: relative;
            overflow: hidden;
        }
        .hero-blob-1 {
            position: absolute; top: -10%; left: -10%;
            width: 40%; padding-top: 40%;
            background: rgba(0, 242, 255, 0.08);
            filter: blur(120px); border-radius: 50%;
            z-index: 0;
        }
        .hero-blob-2 {
            position: absolute; bottom: 10%; right: -10%;
            width: 30%; padding-top: 30%;
            background: rgba(0, 102, 255, 0.08);
            filter: blur(100px); border-radius: 50%;
            z-index: 0;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .4rem 1rem;
            background: rgba(0, 242, 255, 0.1);
            color: var(--brand-primary);
            border-radius: 50px;
            font-size: .72rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase;
            border: 1px solid rgba(0, 242, 255, 0.2);
        }
        .hero-title {
            font-size: clamp(2.6rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -.02em;
            color: #fff;
        }
        .hero-gradient {
            background: linear-gradient(90deg, var(--brand-primary), var(--brand-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-cta-hero {
            background: var(--brand-primary); color: var(--bg-dark);
            font-weight: 700; font-size: 1rem;
            border-radius: 16px; padding: 1rem 2rem;
            border: none;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.3);
            display: inline-flex; align-items: center; gap: .5rem;
            transition: all .2s;
            text-decoration: none;
        }
        .btn-cta-hero:hover { 
            background: #fff; color: var(--brand-secondary); 
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.5);
            transform: translateY(-2px);
        }
        .btn-cta-hero:active { transform: scale(.97); }
        .btn-cta-hero .bi { transition: transform .2s; }
        .btn-cta-hero:hover .bi { transform: translateX(4px); }
        
        .hero-img-wrapper {
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 8px;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }
        .hero-img-wrapper img { border-radius: 18px; width: 100%; object-fit: cover; opacity: 0.9; }

        /* ---- Features ---- */
        .features-section { padding: 6rem 0; position: relative; z-index: 1; }
        .section-title { font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 800; letter-spacing: -.02em; color: #fff; }
        .feature-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,.2);
            transition: all .25s ease;
            height: 100%;
            backdrop-filter: blur(12px);
        }
        .feature-card:hover {
            transform: translateY(-6px);
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(0, 242, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 242, 255, 0.1);
        }
        .feature-icon {
            width: 48px; height: 48px;
            background: rgba(0, 242, 255, 0.1);
            border: 1px solid rgba(0, 242, 255, 0.2);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: var(--brand-primary);
            box-shadow: inset 0 0 10px rgba(0,242,255,0.1);
        }

        /* ---- CTA Banner ---- */
        .cta-section { padding: 6rem 0; position: relative; z-index: 1; }
        .cta-banner {
            background: rgba(0, 102, 255, 0.2);
            border: 1px solid rgba(0, 242, 255, 0.2);
            border-radius: 3rem;
            padding: 4rem 3.5rem;
            overflow: hidden;
            position: relative;
            box-shadow: 0 0 40px rgba(0, 102, 255, 0.2);
            backdrop-filter: blur(12px);
        }
        .cta-banner::before {
            content: '';
            position: absolute; top: -50%; left: -50%;
            width: 100%; height: 200%;
            background: radial-gradient(circle, rgba(0,242,255,0.1) 0%, transparent 70%);
            z-index: 0; pointer-events: none;
        }
        .cta-banner h2 { font-size: clamp(1.8rem, 3.5vw, 2.8rem); font-weight: 800; color: #fff; }
        .btn-cta-white {
            background: var(--brand-primary);
            color: var(--bg-dark);
            font-weight: 700; font-size: 1rem;
            border-radius: 16px; padding: 1rem 2.5rem;
            border: none;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.4);
            transition: all .2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cta-white:hover { 
            background: #fff; 
            color: var(--brand-secondary); 
            transform: translateY(-2px);
        }
        .btn-cta-white:active { transform: scale(.97); }

        /* ---- Footer ---- */
        .footer-custom { 
            background: rgba(10, 25, 47, 0.8); 
            color: #e2e8f0; 
            padding: 4rem 0 2rem; 
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer-logo-box {
            width: 36px; height: 36px;
            background: var(--brand-secondary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .footer-link { color: #94a3b8; text-decoration: none; font-size: .9rem; transition: color .2s; }
        .footer-link:hover { color: var(--brand-primary); }
        .footer-heading { font-weight: 700; font-size: .95rem; margin-bottom: 1.25rem; color: #fff; }
        .footer-divider { border-color: rgba(255,255,255,0.1); }

        /* ---- Fade-in animation ---- */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up       { animation: fadeUp .6s ease both; }
        .fade-up-delay { animation: fadeUp .9s .25s ease both; }
    </style>
</head>
<body>

{{-- ============================================================
     NAVBAR
     ============================================================ --}}
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="/">
            <div class="navbar-brand-logo">
                <i class="bi bi-box-seam text-white fs-5"></i>
            </div>
            <span class="text-white">SmartInventory <span style="color: var(--brand-primary)">Pro</span></span>
        </a>

        {{-- Toggler móvil --}}
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-3 text-white"></i>
        </button>

        {{-- Links + CTAs --}}
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto gap-lg-3 gap-2 py-3 py-lg-0">
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#features">Características</a></li>
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#solutions">Soluciones</a></li>
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#about">Nosotros</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn btn-login">Ingresar</a>
                <a href="{{ route('register') }}" class="btn btn-register-nav">Registrarse</a>
            </div>
        </div>
    </div>
</nav>

{{-- ============================================================
     HERO
     ============================================================ --}}
<section class="hero-section">
    <div class="hero-blob-1"></div>
    <div class="hero-blob-2"></div>

    <div class="container position-relative" style="z-index:1;">
        <div class="text-center fade-up">

            <span class="hero-badge mb-4">
                <i class="bi bi-lightning-fill"></i>
                Gestión de Inventario de Próxima Generación
            </span>

            <h1 class="hero-title mt-3 mb-4 font-display">
                Controla tu Inventario con <br>
                <span class="hero-gradient">Inteligencia Real</span>
            </h1>

            <p class="text-secondary mx-auto mb-5" style="max-width:600px; font-size:1.1rem; line-height:1.7;">
                Optimiza tus operaciones, reduce costos y escala tu negocio con nuestra plataforma de gestión inteligente diseñada para empresas modernas.
            </p>

            <a href="{{ route('register') }}" class="btn btn-cta-hero">
                Empezar Gratis
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        {{-- Dashboard preview --}}
        <div class="fade-up-delay mt-5 mx-auto" style="max-width:960px;">
            <div class="hero-img-wrapper">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1200"
                     alt="Dashboard Preview"
                     referrerpolicy="no-referrer">
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FEATURES
     ============================================================ --}}
<section id="features" class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3 font-display">Todo lo que necesitas para crecer</h2>
            <p class="text-secondary mx-auto" style="max-width:560px;">
                Herramientas potentes diseñadas para simplificar la complejidad de tu inventario.
            </p>
        </div>

        <div class="row g-4">
            @php
                $features = [
                    ['icon' => 'bi-bar-chart-line',        'title' => 'Análisis en Tiempo Real',        'desc' => 'Visualiza tus métricas clave y tendencias de ventas al instante con dashboards interactivos.'],
                    ['icon' => 'bi-shield-check',           'title' => 'Seguridad de Grado Empresarial', 'desc' => 'Tus datos están protegidos con los más altos estándares de cifrado y respaldos automáticos.'],
                    ['icon' => 'bi-lightning-charge',       'title' => 'Automatización Inteligente',     'desc' => 'Alertas de bajo stock y pedidos automáticos para que nunca te quedes sin productos.'],
                    ['icon' => 'bi-globe',                  'title' => 'Gestión Multi-Almacén',          'desc' => 'Controla múltiples ubicaciones desde una sola interfaz centralizada y fácil de usar.'],
                    ['icon' => 'bi-people',                 'title' => 'Colaboración de Equipo',         'desc' => 'Asigna roles y permisos específicos para que tu equipo trabaje de forma sincronizada.'],
                    ['icon' => 'bi-file-earmark-bar-graph', 'title' => 'Reportes Detallados',            'desc' => 'Genera informes personalizados de inventario, ventas y rendimiento en segundos.'],
                ];
            @endphp

            @foreach ($features as $feature)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon mb-4">
                        <i class="bi {{ $feature['icon'] }}"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2 font-display">{{ $feature['title'] }}</h3>
                    <p class="text-secondary mb-0" style="line-height:1.65;">{{ $feature['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     CTA BANNER
     ============================================================ --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-banner">
            <div class="position-relative" style="z-index:1; max-width:680px;">
                <h2 class="mb-4 font-display">
                    ¿Listo para transformar tu gestión de inventario?
                </h2>
                <p class="mb-5" style="color: #cbd5e1; font-size:1.05rem; line-height:1.7;">
                    Únete a miles de empresas que ya están optimizando sus procesos con SmartInventory Pro.
                    Prueba gratuita de 14 días, sin tarjeta de crédito.
                </p>
                <a href="{{ route('register') }}" class="btn-cta-white">
                    Registrarse ahora
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FOOTER
     ============================================================ --}}
<footer class="footer-custom">
    <div class="container">
        <div class="row g-5 mb-5">
            {{-- Brand --}}
            <div class="col-12 col-md-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="footer-logo-box">
                        <i class="bi bi-box-seam text-white"></i>
                    </div>
                    <span class="fw-bold font-display" style="font-size:1.1rem;">
                        SmartInventory <span style="color:var(--brand-primary)">Pro</span>
                    </span>
                </div>
                <p class="footer-link" style="max-width:320px; line-height:1.7;">
                    La solución definitiva para el control de inventario inteligente. Diseñada para escalar negocios de todos los tamaños.
                </p>
            </div>

            {{-- Producto --}}
            <div class="col-6 col-md-3">
                <p class="footer-heading">Producto</p>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="#" class="footer-link">Características</a></li>
                    <li><a href="#" class="footer-link">Precios</a></li>
                    <li><a href="#" class="footer-link">Seguridad</a></li>
                </ul>
            </div>

            {{-- Compañía --}}
            <div class="col-6 col-md-3">
                <p class="footer-heading">Compañía</p>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="#" class="footer-link">Sobre nosotros</a></li>
                    <li><a href="#" class="footer-link">Contacto</a></li>
                    <li><a href="#" class="footer-link">Blog</a></li>
                </ul>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 pt-3 pb-2">
            <p class="footer-link mb-0" style="font-size:.85rem;">
                © {{ date('Y') }} SmartInventory Pro. Todos los derechos reservados.
            </p>
            <div class="d-flex gap-4">
                <a href="#" class="footer-link" style="font-size:.85rem;">Privacidad</a>
                <a href="#" class="footer-link" style="font-size:.85rem;">Términos</a>
            </div>
        </div>
    </div>
</footer>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
