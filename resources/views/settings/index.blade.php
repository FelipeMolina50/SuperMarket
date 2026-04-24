<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - ValleStock</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --brand-secondary: #3b82f6;
            --bg-body: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active-text: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #334155;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); }
        .font-display { font-family: 'Outfit', sans-serif; }

        /* Sidebar & Header Shared Styles */
        .sidebar { width: 250px; background-color: var(--sidebar-bg); color: var(--sidebar-text); min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar-header { padding: 1.5rem; display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .sidebar-logo-box { background-color: var(--brand-secondary); padding: 0.5rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; }
        .sidebar-nav { padding: 1.5rem 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .nav-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.5rem; color: var(--sidebar-text); text-decoration: none; transition: all 0.2s; font-weight: 500; }
        .nav-item:hover, .nav-item.active { background-color: rgba(255, 255, 255, 0.1); color: var(--sidebar-active-text); }
        
        .header { background-color: #ffffff; padding: 1.25rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }

        /* Configuration Specific Styles */
        .settings-card { background: white; border-radius: 1.5rem; border: 1px solid var(--border-color); overflow: hidden; min-height: 600px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .settings-sidebar { width: 250px; background: #f8fafc; border-right: 1px solid var(--border-color); padding: 2rem 0; }
        .settings-nav-item { padding: 1rem 2rem; display: flex; align-items: center; gap: 1rem; color: #64748b; cursor: pointer; transition: all 0.2s; border-right: 3px solid transparent; }
        .settings-nav-item:hover { background: #f1f5f9; color: var(--text-main); }
        .settings-nav-item.active { background: white; color: var(--brand-secondary); border-right-color: var(--brand-secondary); }
        
        .profile-img-large { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        
        .input-field { width: 100%; border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; background-color: white; transition: all 0.2s; }
        .input-field:focus { outline: none; border-color: var(--brand-secondary); box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1); }
        
        .btn-outline { background-color: white; border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; font-weight: 500; color: var(--text-main); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s; }
        .btn-outline:hover { background-color: #f8fafc; border-color: #cbd5e1; }
        
        .btn-primary-blue { background-color: var(--brand-secondary); color: white; border: none; border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .btn-primary-blue:hover { background-color: #2563eb; }
    </style>
</head>
<body class="flex min-h-screen">
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.png') }}" alt="ValleStock Logo" style="height: 38px; width: auto; object-fit: contain;">
            <span class="font-display" style="color: white; font-weight: 700; font-size: 1.25rem;">ValleStock</span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item"><i data-lucide="layout-dashboard"></i> Panel de Control</a>
            <a href="{{ route('inventory.index') }}" class="nav-item"><i data-lucide="package"></i> Inventario</a>
            <a href="{{ route('orders.index') }}" class="nav-item"><i data-lucide="shopping-cart"></i> Pedidos</a>
            <a href="{{ route('reports.index') }}" class="nav-item"><i data-lucide="bar-chart-3"></i> Informes</a>
            <a href="{{ route('settings.index') }}" class="nav-item active"><i data-lucide="settings"></i> Configuración</a>
        </nav>
    </aside>

    <main class="flex-1 overflow-x-hidden">
        <header class="header">
            <h1 class="text-2xl font-display font-bold text-slate-900">Administración</h1>
            <div class="flex items-center gap-4">
                <div style="position: relative; display: flex; align-items: center;">
                    <i data-lucide="bell" class="w-5 h-5 text-slate-400" style="cursor: pointer;"></i>
                </div>
                
                {{-- Dropdown de Perfil Integrado en Laravel --}}
                <div class="relative group flex items-center">
                    {!! auth()->user()->avatarHtml('40px', '1.25rem') !!}
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-slate-200 hidden group-hover:block z-50">
                        <div class="px-4 py-2 text-sm text-slate-700 border-b border-slate-100 font-medium">
                            {{ auth()->user()->name ?? 'Administrador' }}
                        </div>
                        <form method="POST" action="{{ route('logout') ?? '#' }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-50">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Botón de Salir (Rápido) -->
                <form method="POST" action="{{ route('logout') ?? '#' }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-outline" style="width: auto; padding: 0.625rem 1.5rem; color: #ef4444; border-color: #fecaca;">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Salir
                    </button>
                </form>
            </div>
        </header>

        <div class="p-8 max-w-5xl">
            <div class="settings-card flex flex-col md:flex-row">
                <div class="settings-sidebar">
                    <div class="settings-nav-item active" onclick="showTab('profile')">
                        <i data-lucide="user" class="w-5 h-5"></i><span class="text-sm font-bold">Perfil</span>
                    </div>
                    <div class="settings-nav-item" onclick="showTab('security')">
                        <i data-lucide="lock" class="w-5 h-5"></i><span class="text-sm font-bold">Seguridad</span>
                    </div>
                    <div class="settings-nav-item" onclick="showTab('notifications')">
                        <i data-lucide="bell" class="w-5 h-5"></i><span class="text-sm font-bold">Notificaciones</span>
                    </div>
                    
                    @if(auth()->user()->role === 'super_admin')
                    <div class="settings-nav-item" onclick="showTab('users')">
                        <i data-lucide="users" class="w-5 h-5"></i><span class="text-sm font-bold">Usuarios ({{ isset($pendingUsers) ? $pendingUsers->count() : 0 }})</span>
                    </div>
                    @endif
                </div>

                <div id="tab-profile" class="flex-1 p-8 space-y-8">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <div class="flex items-center gap-6">
                            <div style="position: relative;" id="avatar_container">
                                {!! auth()->user()->avatarHtml('100px', '3rem') !!}
                                <button type="button" onclick="document.getElementById('avatar_upload').click()" class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-lg border border-slate-200 hover:bg-slate-50 transition">
                                    <i data-lucide="camera" class="w-4 h-4 text-slate-600"></i>
                                </button>
                                <input type="file" name="avatar_file" id="avatar_upload" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                            </div>
                            <div>
                                <h3 id="display-name-header" class="text-xl font-bold text-slate-900">{{ auth()->user()->name ?? 'Usuario' }}</h3>
                                <p id="role-display" class="text-slate-500">{{ auth()->user()->role === 'super_admin' ? 'Super Administrador' : 'Usuario' }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3">Cambiar Avatar (Opcional)</label>
                            <div class="flex gap-4">
                                <label class="cursor-pointer group relative">
                                    <input type="radio" name="avatar" value="fox" class="hidden peer" {{ auth()->user()->avatar === 'fox' ? 'checked' : '' }} onchange="updateProfileAvatarSelected(this)">
                                    <div class="avatar-option-profile w-16 h-16 rounded-full border-4 {{ auth()->user()->avatar === 'fox' ? 'border-blue-500' : 'border-transparent' }} bg-orange-100 flex items-center justify-center text-3xl transition group-hover:scale-110">🦊</div>
                                </label>
                                <label class="cursor-pointer group relative">
                                    <input type="radio" name="avatar" value="cat" class="hidden peer" {{ auth()->user()->avatar === 'cat' ? 'checked' : '' }} onchange="updateProfileAvatarSelected(this)">
                                    <div class="avatar-option-profile w-16 h-16 rounded-full border-4 {{ auth()->user()->avatar === 'cat' ? 'border-blue-500' : 'border-transparent' }} bg-blue-100 flex items-center justify-center text-3xl transition group-hover:scale-110">🐱</div>
                                </label>
                                <label class="cursor-pointer group relative">
                                    <input type="radio" name="avatar" value="dog" class="hidden peer" {{ auth()->user()->avatar === 'dog' ? 'checked' : '' }} onchange="updateProfileAvatarSelected(this)">
                                    <div class="avatar-option-profile w-16 h-16 rounded-full border-4 {{ auth()->user()->avatar === 'dog' ? 'border-blue-500' : 'border-transparent' }} bg-green-100 flex items-center justify-center text-3xl transition group-hover:scale-110">🐶</div>
                                </label>
                                <label class="cursor-pointer group relative">
                                    <input type="radio" name="avatar" value="panda" class="hidden peer" {{ auth()->user()->avatar === 'panda' ? 'checked' : '' }} onchange="updateProfileAvatarSelected(this)">
                                    <div class="avatar-option-profile w-16 h-16 rounded-full border-4 {{ auth()->user()->avatar === 'panda' ? 'border-blue-500' : 'border-transparent' }} bg-pink-100 flex items-center justify-center text-3xl transition group-hover:scale-110">🐼</div>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700">Nombre Completo</label>
                                <input type="text" name="name" class="input-field" value="{{ auth()->user()->name ?? 'Administrador' }}" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700">Correo Electrónico</label>
                                <input type="email" class="input-field" value="{{ auth()->user()->email ?? 'admin@ejemplo.com' }}" readonly style="background: #f8fafc;">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700">Nombre de la Empresa</label>
                                <input type="text" name="company_name" class="input-field" value="{{ auth()->user()->company_name }}" placeholder="Empresa S.A.">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700">Rol del Usuario</label>
                                <select class="input-field" disabled>
                                    <option value="user" {{ auth()->user()->role === 'user' ? 'selected' : '' }}>Usuario Regular</option>
                                    <option value="super_admin" {{ auth()->user()->role === 'super_admin' ? 'selected' : '' }}>Super Administrador</option>
                                </select>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn-primary-blue" style="width: auto; padding: 0.625rem 2rem;">
                                <i data-lucide="save" class="w-4 h-4"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>

                <div id="tab-security" class="flex-1 p-8 space-y-8" style="display: none;">
                    <h3 class="text-xl font-bold text-slate-900">Seguridad de la Cuenta</h3>
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Contraseña Actual</label>
                            <input type="password" class="input-field" placeholder="••••••••">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Nueva Contraseña</label>
                            <input type="password" class="input-field" placeholder="••••••••">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Confirmar Nueva Contraseña</label>
                            <input type="password" class="input-field" placeholder="••••••••">
                        </div>
                        <button class="btn-primary-blue" style="width: auto;">
                            Actualizar Contraseña
                        </button>
                    </div>
                </div>

                <!-- Notificaciones -->
                <div id="tab-notifications" class="flex-1 p-8 space-y-8" style="display: none;">
                    <h3 class="text-xl font-bold text-slate-900">Notificaciones</h3>
                    <p class="text-slate-500">Manejo de alertas por stock bajo o nueva orden.</p>
                </div>
                
                <!-- Gestión de Usuarios (Sólo Admin) -->
                @if(auth()->user()->role === 'super_admin')
                <div id="tab-users" class="flex-1 p-8 space-y-8" style="display: none;">
                    <h3 class="text-xl font-bold text-slate-900">Solicitudes Pendientes</h3>
                    <p class="text-slate-500">Usuarios que se han registrado y esperan aprobación para entrar al sistema.</p>
                    
                    @if(isset($pendingUsers) && $pendingUsers->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingUsers as $user)
                            <div class="flex items-center justify-between p-4 border border-slate-200 rounded-xl bg-white shadow-sm">
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $user->name }}</h4>
                                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                                    <span class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded mt-1 inline-block">Pendiente</span>
                                </div>
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('settings.approve', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn-primary-blue" style="background-color: #10b981; padding: 0.5rem 1rem;">
                                            Aprobar
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('settings.reject', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn-outline" style="color: #ef4444; border-color: #fecaca; padding: 0.5rem 1rem;">
                                            Rechazar
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-8 border border-dashed border-slate-300 rounded-xl">
                            <i data-lucide="check-circle" class="w-8 h-8 text-green-500 mx-auto mb-2"></i>
                            <p class="text-slate-600 font-medium">Todo al día</p>
                            <p class="text-sm text-slate-400">No hay usuarios pendientes de aprobación.</p>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();

        // Control visual de Pestañas
        window.showTab = (tabName) => {
            document.getElementById('tab-profile').style.display = tabName === 'profile' ? 'block' : 'none';
            document.getElementById('tab-security').style.display = tabName === 'security' ? 'block' : 'none';
            document.getElementById('tab-notifications').style.display = tabName === 'notifications' ? 'block' : 'none';
            if (document.getElementById('tab-users')) {
                document.getElementById('tab-users').style.display = tabName === 'users' ? 'block' : 'none';
            }
            
            document.querySelectorAll('.settings-nav-item').forEach(item => {
                item.classList.remove('active');
                if (item.innerText.toLowerCase().includes(tabName === 'profile' ? 'perfil' : (tabName === 'security' ? 'seguridad' : (tabName === 'notifications' ? 'notificaciones' : 'usuarios')))) {
                    item.classList.add('active');
                }
            });
        };

        function updateProfileAvatarSelected(radio) {
            document.querySelectorAll('.avatar-option-profile').forEach(el => {
                el.classList.remove('border-blue-500');
                el.classList.add('border-transparent');
            });
            if(radio.checked) {
                radio.nextElementSibling.classList.remove('border-transparent');
                radio.nextElementSibling.classList.add('border-blue-500');
            }
            // Limpiar file si seleccionó un emoji
            document.getElementById('avatar_upload').value = '';
        }

        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.getElementById('avatar_container');
                    const oldImg = container.querySelector('.avatar-img');
                    if(oldImg) oldImg.remove();
                    
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'avatar-img';
                    newImg.style = "width:100px; height:100px; border-radius:50%; object-fit:cover; border:2px solid white; box-shadow:0 1px 2px rgba(0,0,0,0.1); cursor:pointer;";
                    
                    container.insertBefore(newImg, container.firstChild);
                    
                    // Deseleccionar radios
                    document.querySelectorAll('input[name="avatar"]').forEach(r => r.checked = false);
                    document.querySelectorAll('.avatar-option-profile').forEach(el => {
                        el.classList.remove('border-blue-500');
                        el.classList.add('border-transparent');
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
