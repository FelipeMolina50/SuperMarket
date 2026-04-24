<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ingresar – ValleStock</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #00f2ff;
            --brand-secondary: #0066ff;
            --bg-dark: #0a192f;
        }

        * { box-sizing: border-box; }

        body, html {
            margin: 0; padding: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            overflow-x: hidden;
        }

        h1, h2, h3, .font-display { font-family: 'Outfit', sans-serif; }

        /* ---- Background image ---- */
        .bg-warehouse {
            position: fixed; inset: 0; z-index: 0;
            background-color: var(--bg-dark);
        }
        .bg-warehouse img {
            width: 100%; height: 100%;
            object-fit: cover; opacity: 0.15;
            mix-blend-mode: luminosity;
        }
        .bg-warehouse-overlay {
            position: absolute; inset: 0;
            background: radial-gradient(circle at center, rgba(10,25,47,0.3) 0%, var(--bg-dark) 100%);
        }

        /* ---- Main wrapper ---- */
        .login-wrapper {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex; align-items: center;
            padding: 3rem 1.5rem;
        }

        /* ---- Left: branding text ---- */
        .login-brand-icon {
            width: 52px; height: 52px;
            background: rgba(99,102,241,.2);
            border: 1px solid rgba(99,102,241,.35);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            color: var(--brand-primary);
        }
        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-weight: 800; font-size: 1.4rem;
            color: #fff; letter-spacing: -.01em;
        }
        .hero-heading {
            font-size: clamp(2rem, 4.5vw, 3.6rem);
            font-weight: 800; line-height: 1.12;
            color: #fff;
        }
        .hero-heading .highlight { color: var(--brand-primary); }
        .hero-sub { color: #cbd5e1; font-size: 1.1rem; line-height: 1.7; }
        .hero-caption { color: #94a3b8; font-weight: 600; font-size: .95rem; }

        /* ---- Glass card ---- */
        .glass-card {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 28px;
            padding: 2.5rem 2rem;
            box-shadow: 0 32px 80px rgba(0,0,0,.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }
        .glass-card::before {
            content: '';
            position: absolute; top: -80px; left: -80px;
            width: 200px; height: 200px;
            background: rgba(99,102,241,.18);
            filter: blur(60px); border-radius: 50%;
            pointer-events: none;
        }

        /* ---- Form elements ---- */
        .form-label-custom {
            color: #cbd5e1; font-size: .85rem;
            font-weight: 500; margin-bottom: .4rem;
        }
        .input-icon-wrapper { position: relative; }
        .input-icon-wrapper .bi {
            position: absolute; left: 14px;
            top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 1rem;
            pointer-events: none;
        }
        .input-custom {
            width: 100%;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 12px;
            padding: .9rem 1rem .9rem 2.75rem;
            color: #fff; font-size: .95rem;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .input-custom::placeholder { color: #64748b; }
        .input-custom:focus {
            border-color: rgba(99,102,241,.55);
            box-shadow: 0 0 0 3px rgba(99,102,241,.18);
            background: rgba(255,255,255,.08);
        }

        /* ---- Forgot password --  */
        .forgot-link {
            color: var(--brand-primary); font-size: .85rem;
            font-weight: 500; text-decoration: none;
        }
        .forgot-link:hover { text-decoration: underline; color: var(--brand-primary); }

        /* ---- Submit button ---- */
        .btn-submit {
            width: 100%;
            background: var(--brand-primary);
            color: #fff; font-weight: 700; font-size: 1rem;
            border: none; border-radius: 12px;
            padding: .95rem 1rem;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            box-shadow: 0 0 24px rgba(99,102,241,.4);
            transition: background .2s, transform .15s, box-shadow .2s;
            cursor: pointer;
        }
        .btn-submit:hover {
            background: #4f46e5;
            box-shadow: 0 0 32px rgba(99,102,241,.55);
        }
        .btn-submit:active { transform: scale(.97); }
        .btn-submit .bi { transition: transform .2s; }
        .btn-submit:hover .bi { transform: translateX(4px); }

        /* ---- Register link ---- */
        .register-link { color: var(--brand-primary); font-weight: 700; text-decoration: none; }
        .register-link:hover { text-decoration: underline; color: var(--brand-primary); }

        /* ---- Validation errors (Laravel) ---- */
        .input-error { border-color: #f87171 !important; }
        .error-msg { color: #f87171; font-size: .8rem; margin-top: .3rem; }

        /* ---- Fade-in animations ---- */
        @keyframes fadeLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeScale {
            from { opacity: 0; transform: scale(.93); }
            to   { opacity: 1; transform: scale(1); }
        }
        .anim-left  { animation: fadeLeft  .8s ease both; }
        .anim-scale { animation: fadeScale .6s .2s ease both; }
    </style>
</head>
<body>

{{-- Background --}}
<div class="bg-warehouse">
    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=2000"
         alt="Warehouse" referrerpolicy="no-referrer">
    <div class="bg-warehouse-overlay"></div>
</div>

{{-- Main --}}
<div class="login-wrapper">
    <div class="container">
        <div class="row align-items-center justify-content-between gy-5">

            {{-- ============ LEFT: Branding ============ --}}
            <div class="col-12 col-lg-6 anim-left">

                {{-- Logo --}}
                <div class="d-flex align-items-center gap-3 mb-5">
                    <img src="{{ asset('images/logo.png') }}" alt="ValleStock Logo" style="height: 52px; width: auto; object-fit: contain;">
                    <span class="brand-name">ValleStock</span>
                </div>

                {{-- Headline --}}
                <h1 class="hero-heading mb-4">
                    Bienvenido a ValleStock.<br>
                    <span class="highlight">Control Inteligente</span> para su Negocio.
                </h1>

                <p class="hero-sub mb-4" style="max-width:480px;">
                    Optimice sus operaciones con nuestro sistema avanzado de gestión de inventario.
                </p>

                <p class="hero-caption">Sus datos, seguros y accesibles.</p>
            </div>

            {{-- ============ RIGHT: Login Card ============ --}}
            <div class="col-12 col-lg-5 anim-scale">
                <div class="glass-card">

                    {{-- Card header --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="ValleStock Logo" class="mb-3 d-block" style="height: 3.5rem; width: auto; object-fit: contain;">
                        <h2 class="font-display text-white fw-bold fs-3 mb-0">Acceso Smart Premium</h2>
                    </div>

                    {{-- Session / validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 py-2 px-3 mb-4" role="alert" style="font-size:.85rem;">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success rounded-3 py-2 px-3 mb-4" role="alert" style="font-size:.85rem;">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label-custom d-block">Correo Electrónico</label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-envelope"></i>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="input-custom @error('email') input-error @enderror"
                                    placeholder="correo@empresa.com"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="email"
                                >
                            </div>
                            @error('email')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-2">
                            <label for="password" class="form-label-custom d-block">Contraseña</label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-lock"></i>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="input-custom @error('password') input-error @enderror"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="current-password"
                                >
                            </div>
                            @error('password')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Forgot password --}}
                        <div class="text-end mb-4">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    ¿Olvidó su contraseña?
                                </a>
                            @endif
                        </div>

                        {{-- Remember me (optional) --}}
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                   {{ old('remember') ? 'checked' : '' }}
                                   style="background-color:rgba(255,255,255,.1); border-color:rgba(255,255,255,.2);">
                            <label class="form-check-label" for="remember" style="color:#94a3b8; font-size:.85rem;">
                                Recordarme
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-submit mb-4">
                            Entrar al Sistema
                            <i class="bi bi-arrow-right"></i>
                        </button>

                        {{-- Register link --}}
                        <p class="text-center mb-0" style="color:#94a3b8; font-size:.875rem;">
                            ¿No tiene una cuenta?
                            <a href="{{ route('register') }}" class="register-link">Registrarse</a>
                        </p>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
