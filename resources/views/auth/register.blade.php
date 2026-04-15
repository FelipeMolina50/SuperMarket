<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro – SmartInventory Pro</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root { 
            --blue: #0066ff; 
            --brand-primary: #00f2ff;
            --bg-slate-50: #f8fafc;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body, html {
            margin: 0; padding: 0; min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: var(--bg-slate-50);
        }
        h1, h2, h3, .font-display { font-family: 'Outfit', sans-serif; }

        /* ============ LEFT PANEL ============ */
        .panel-left {
            background: var(--blue);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 2.5rem;
            position: relative; overflow: hidden;
        }
        .panel-left::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at center, rgba(255,255,255,.12) 0%, transparent 70%);
        }
        .panel-shield {
            width: 80px; height: 80px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.4rem; color: #fff;
            backdrop-filter: blur(8px);
        }
        .panel-img {
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,.2);
            box-shadow: 0 32px 60px rgba(0,0,0,.3);
            width: 100%; object-fit: cover;
        }

        /* ============ RIGHT PANEL ============ */
        .panel-right {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 2rem;
            overflow-y: auto;
        }
        .form-inner { width: 100%; max-width: 480px; }

        /* ---- Inputs ---- */
        .form-label-custom {
            font-size: .85rem; font-weight: 600;
            color: #334155; margin-bottom: .4rem; display: block;
        }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap .bi {
            position: absolute; left: 14px;
            top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 1rem; pointer-events: none;
        }
        .input-custom {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: .8rem 1rem .8rem 2.75rem;
            font-size: .95rem; color: #0f172a;
            outline: none; transition: border-color .2s, box-shadow .2s;
        }
        .input-custom:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,.15);
        }
        .input-custom.is-invalid { border-color: #f87171; }
        .toggle-pw {
            position: absolute; right: 14px;
            top: 50%; transform: translateY(-50%);
            background: none; border: none; padding: 0;
            color: #94a3b8; cursor: pointer; font-size: 1rem;
            transition: color .2s;
        }
        .toggle-pw:hover { color: #475569; }

        /* ---- Category pills ---- */
        .cat-btn {
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: .4rem; padding: .9rem .5rem;
            border: 2px solid #f1f5f9;
            border-radius: 14px; background: #fff;
            cursor: pointer; transition: all .2s;
            width: 100%;
        }
        .cat-btn:hover { border-color: #cbd5e1; }
        .cat-btn .cat-icon { font-size: 1.6rem; }
        .cat-btn .cat-label { font-size: .75rem; font-weight: 700; color: #334155; }

        /* Selected states per category */
        .cat-btn.sel-electronics { background:#eff6ff; border-color:#93c5fd; }
        .cat-btn.sel-grocery     { background:#f0fdf4; border-color:#86efac; }
        .cat-btn.sel-pharmacy    { background:#fef2f2; border-color:#fca5a5; }
        .cat-btn.sel-hardware    { background:#fff7ed; border-color:#fdba74; }
        .cat-btn.sel-clothing    { background:#faf5ff; border-color:#d8b4fe; }
        .cat-btn.selected        { transform: scale(1.05); box-shadow: 0 4px 14px rgba(0,0,0,.08); }

        .cat-icon-electronics { color: #2563eb; }
        .cat-icon-grocery     { color: #16a34a; }
        .cat-icon-pharmacy    { color: #dc2626; }
        .cat-icon-hardware    { color: #ea580c; }
        .cat-icon-clothing    { color: #9333ea; }

        /* ---- Submit ---- */
        .btn-submit {
            width: 100%; background: var(--blue);
            color: #fff; font-weight: 700; font-size: 1rem;
            border: none; border-radius: 12px;
            padding: .95rem 1rem;
            box-shadow: 0 8px 24px rgba(37,99,235,.25);
            transition: background .2s, transform .15s;
            cursor: pointer;
        }
        .btn-submit:hover { background: #1d4ed8; }
        .btn-submit:active { transform: scale(.97); }

        /* ---- Terms checkbox ---- */
        .terms-check { width: 18px; height: 18px; accent-color: var(--blue); cursor: pointer; flex-shrink: 0; }
        .terms-label { font-size: .875rem; color: #475569; }
        .terms-link { color: var(--blue); font-weight: 600; text-decoration: none; }
        .terms-link:hover { text-decoration: underline; }

        /* ---- Login link ---- */
        .login-link { color: var(--blue); font-weight: 700; text-decoration: none; }
        .login-link:hover { text-decoration: underline; }

        /* ---- Error msgs ---- */
        .error-msg { color: #f87171; font-size: .8rem; margin-top: .3rem; }

        /* ---- Fade-in ---- */
        @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeScale { from { opacity:0; transform:scale(.9); } to { opacity:1; transform:scale(1); } }
        .anim-up    { animation: fadeUp    .7s ease both; }
        .anim-scale { animation: fadeScale .8s ease both; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">

        {{-- ============ LEFT: Branding ============ --}}
        <div class="col-12 col-lg-6 d-none d-lg-flex panel-left">
            <div class="position-relative z-1 text-center" style="max-width:420px;">

                <div class="anim-scale">
                    <div class="d-flex justify-content-center mb-4">
                        <div class="panel-shield">
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>
                    <h1 class="text-white fw-bold mb-2" style="font-size:3rem; letter-spacing:-.02em;">SmartStock</h1>
                    <p class="mb-5" style="color:#bfdbfe; font-size:1.1rem;">
                        Únase a una forma más inteligente de gestionar su inventario.
                    </p>
                </div>

                <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&q=80&w=800"
                     alt="Inventory"
                     class="panel-img"
                     referrerpolicy="no-referrer">
            </div>
        </div>

        {{-- ============ RIGHT: Form ============ --}}
        <div class="col-12 col-lg-6 panel-right">
            <div class="form-inner anim-up">

                {{-- Header --}}
                <div class="text-center mb-4">
                    <h2 class="font-display fw-bold text-dark mb-1" style="font-size:1.75rem;">
                        Registro de Negocio Personalizado
                    </h2>
                    <p class="text-secondary mb-0" style="font-size:.95rem;">
                        Cree su cuenta y personalice su incorporación.
                    </p>
                </div>

                {{-- Errors --}}
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

                {{-- Form --}}
                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label-custom">Nombre completo</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-person"></i>
                            <input type="text" id="name" name="name"
                                   class="input-custom @error('name') is-invalid @enderror"
                                   placeholder="Juan Pérez"
                                   value="{{ old('name') }}"
                                   required autofocus autocomplete="name"
                                   style="padding-left:2.75rem;">
                        </div>
                        @error('name') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label-custom">Correo Electrónico</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" id="email" name="email"
                                   class="input-custom @error('email') is-invalid @enderror"
                                   placeholder="correo@empresa.com"
                                   value="{{ old('email') }}"
                                   required autocomplete="username">
                        </div>
                        @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label-custom">Contraseña</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-lock"></i>
                            <input type="password" id="password" name="password"
                                   class="input-custom @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required autocomplete="new-password"
                                   style="padding-right:3rem;">
                            <button type="button" class="toggle-pw" id="togglePw" aria-label="Mostrar contraseña">
                                <i class="bi bi-eye" id="togglePwIcon"></i>
                            </button>
                        </div>
                        @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password confirmation --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label-custom">Confirmar Contraseña</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="input-custom"
                                   placeholder="••••••••"
                                   required autocomplete="new-password">
                        </div>
                    </div>

                    {{-- Category selector --}}
                    <div class="mb-4">
                        <label class="form-label-custom mb-2">¿Qué vende?</label>
                        <div class="row g-2">

                            @php
                                $cats = [
                                    ['id' => 'electronics', 'name' => 'Electrónica',  'icon' => 'bi-cpu'],
                                    ['id' => 'grocery',     'name' => 'Alimentación', 'icon' => 'bi-basket2'],
                                    ['id' => 'pharmacy',    'name' => 'Farmacia',     'icon' => 'bi-capsule'],
                                    ['id' => 'hardware',    'name' => 'Ferretería',   'icon' => 'bi-tools'],
                                    ['id' => 'clothing',    'name' => 'Ropa',         'icon' => 'bi-bag'],
                                ];
                            @endphp

                            @foreach ($cats as $cat)
                            <div class="col-4 col-md-4">
                                <button type="button"
                                        class="cat-btn"
                                        data-cat="{{ $cat['id'] }}"
                                        onclick="selectCat(this, '{{ $cat['id'] }}')">
                                    <i class="bi {{ $cat['icon'] }} cat-icon cat-icon-{{ $cat['id'] }}"></i>
                                    <span class="cat-label">{{ $cat['name'] }}</span>
                                </button>
                            </div>
                            @endforeach

                        </div>
                        {{-- Hidden input para enviar la categoría seleccionada --}}
                        <input type="hidden" name="category" id="categoryInput" value="{{ old('category') }}">
                        @error('category') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    {{-- Terms --}}
                    <div class="d-flex align-items-start gap-2 mb-4">
                        <input type="checkbox" id="terms" name="terms" class="terms-check mt-1"
                               {{ old('terms') ? 'checked' : '' }} required>
                        <label for="terms" class="terms-label">
                            Acepto los
                            <a href="#" class="terms-link">Términos y Condiciones</a>
                            y la
                            <a href="#" class="terms-link">Política de Privacidad</a>
                        </label>
                    </div>
                    @error('terms') <p class="error-msg mt-0 mb-3">{{ $message }}</p> @enderror

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit mb-4">
                        Crear Cuenta
                    </button>

                    {{-- Login link --}}
                    <p class="text-center mb-0" style="color:#64748b; font-size:.875rem;">
                        ¿Ya tiene una cuenta?
                        <a href="{{ route('login') }}" class="login-link">Iniciar Sesión</a>
                    </p>

                </form>
            </div>
        </div>

    </div>
</div>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ---- Toggle password visibility ----
    const pwInput    = document.getElementById('password');
    const toggleBtn  = document.getElementById('togglePw');
    const toggleIcon = document.getElementById('togglePwIcon');

    toggleBtn.addEventListener('click', () => {
        const show = pwInput.type === 'password';
        pwInput.type = show ? 'text' : 'password';
        toggleIcon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    });

    // ---- Category selection ----
    const catInput = document.getElementById('categoryInput');

    // Restore selection if old() has a value
    const oldCat = catInput.value;
    if (oldCat) {
        const el = document.querySelector(`[data-cat="${oldCat}"]`);
        if (el) activateCat(el, oldCat);
    }

    function selectCat(btn, catId) {
        // Deselect all
        document.querySelectorAll('.cat-btn').forEach(b => {
            b.classList.remove('selected');
            // Remove all sel-* classes
            b.className = b.className.replace(/sel-\S+/g, '').trim();
        });
        activateCat(btn, catId);
    }

    function activateCat(btn, catId) {
        btn.classList.add('selected', `sel-${catId}`);
        catInput.value = catId;
    }
</script>

</body>
</html>
