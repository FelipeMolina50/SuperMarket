<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - ValleStock</title>
    <!-- Cargando Tailwind CSS por CDN para que soporten las clases (flex, p-8, gap-4, etc.) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --brand-secondary: #3b82f6;
            --bg-body: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active-text: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: #334155;
            min-height: 100vh;
        }

        .font-display {
            font-family: 'Outfit', sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo-box {
            background-color: var(--brand-secondary);
            padding: 0.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-nav {
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-item:hover, .nav-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--sidebar-active-text);
        }

        /* Header Styles */
        .header {
            background-color: #ffffff;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .search-bar {
            background-color: #f1f5f9;
            border: 1px solid transparent;
            border-radius: 9999px;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s;
            width: 250px;
        }

        .search-bar:focus {
            background-color: #ffffff;
            border-color: var(--brand-secondary);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        /* Notifications Dropdown */
        .notification-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            width: 300px;
            display: none;
            z-index: 50;
            border: 1px solid #e2e8f0;
        }

        .notification-dropdown.active {
            display: block;
        }

        .notification-item {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .notification-item:hover {
            background-color: #f8fafc;
        }

        /* Stat Cards */
        .stat-card {
            background-color: #ffffff;
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .stat-icon-container {
            width: 48px;
            height: 48px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Charts Container */
        .chart-container {
            background-color: #ffffff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .profile-img {
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            cursor: pointer; 
            border: 2px solid transparent;
            transition: border-color 0.2s;
        }

        .profile-img:hover {
            border-color: #2563eb;
        }
    </style>
</head>
<body class="flex">
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.png') }}" alt="ValleStock Logo" style="height: 38px; width: auto; object-fit: contain;">
            <span class="font-display" style="color: white; font-weight: 700; font-size: 1.25rem;">ValleStock</span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item active"><i data-lucide="layout-dashboard"></i> Panel de Control</a>
            <a href="{{ route('inventory.index') }}" class="nav-item"><i data-lucide="package"></i> Inventario</a>
            <a href="{{ route('orders.index') }}" class="nav-item"><i data-lucide="shopping-cart"></i> Pedidos</a>
            <a href="{{ route('reports.index') }}" class="nav-item"><i data-lucide="bar-chart-3"></i> Informes</a>
            <a href="{{ route('settings.index') }}" class="nav-item"><i data-lucide="settings"></i> Configuración</a>
        </nav>
    </aside>

    <main class="flex-1 overflow-x-hidden">
        <header class="header">
            <h1 class="font-display" style="font-size: 1.5rem; font-weight: 700;">Panel de Inventario Inteligente</h1>
            <div class="flex items-center gap-4">
                <div style="position: relative;">
                    <i data-lucide="search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 16px; color: #94a3b8;"></i>
                    <input type="text" class="search-bar" placeholder="Buscar...">
                </div>
                <div class="relative">
                    <i data-lucide="bell" id="notifBtn" style="color: #94a3b8; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#94a3b8'"></i>
                    <div id="notifDropdown" class="notification-dropdown">
                        <div class="p-4 border-b font-bold text-slate-900">Notificaciones</div>
                        <div class="notification-item">
                            <p class="text-sm font-bold text-slate-800">Stock Bajo: Logitech MX Master</p>
                            <p class="text-xs text-slate-500">Hace 5 minutos</p>
                        </div>
                        <div class="notification-item">
                            <p class="text-sm font-bold text-slate-800">Nuevo Pedido: ORD-8829</p>
                            <p class="text-xs text-slate-500">Hace 1 hora</p>
                        </div>
                        <div class="p-3 text-center">
                            <a href="#" class="text-xs text-blue-600 font-bold hover:text-blue-800">Ver todas</a>
                        </div>
                    </div>
                </div>
                
                {{-- Dropdown de Perfil Integrado con Laravel --}}
                <div class="relative group">
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
            </div>
        </header>

        <div class="p-8">
            <div class="flex gap-4 mb-8">
                <!-- Stat Cards -->
                <div class="stat-card flex-1">
                    <div class="stat-icon-container" style="background: #eff6ff; color: #3b82f6;"><i data-lucide="dollar-sign"></i></div>
                    <div><p class="text-xs text-slate-500 font-medium">Valor Total Pedidos</p><p id="totalValue" class="text-2xl font-bold text-slate-800">${{ number_format($totalRevenue ?? 0, 2) }}</p></div>
                </div>
                <div class="stat-card flex-1">
                    <div class="stat-icon-container" style="background: #f5f3ff; color: #6366f1;"><i data-lucide="shopping-cart"></i></div>
                    <div><p class="text-xs text-slate-500 font-medium">Total Pedidos</p><p id="totalOrders" class="text-2xl font-bold text-slate-800">{{ $totalOrders ?? 0 }}</p></div>
                </div>
            </div>

            <div class="chart-container">
                <h3 class="font-display mb-6 font-bold text-lg text-slate-800">Tendencias de Ventas</h3>
                <canvas id="salesChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();

        // Notificaciones
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');

        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notifDropdown.classList.toggle('active');
        });

        document.addEventListener('click', () => {
            notifDropdown.classList.remove('active');
        });

        // Cargar Estadísticas
        // Values injected by blade

        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Ventas',
                    data: [0, 0, 0, 0, 0, 0],
                    borderColor: '#3b82f6',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    </script>

    @if(auth()->check() && empty(auth()->user()->company_name) && auth()->user()->role !== 'super_admin')
    <div id="setupModal" style="position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.8); backdrop-filter: blur(4px); z-index: 100; display: flex; align-items: center; justify-content: center; padding: 1rem;">
        <div style="background-color: white; border-radius: 1rem; width: 100%; max-width: 28rem; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="width: 4rem; height: 4rem; background-color: #dbeafe; color: #2563eb; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                    <i data-lucide="building-2" style="width: 2rem; height: 2rem;"></i>
                </div>
                <h2 class="font-display" style="font-size: 1.5rem; font-weight: 700; color: #0f172a;">Configura tu Empresa</h2>
                <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.875rem;">Para comenzar a usar ValleStock, necesitamos algunos datos básicos.</p>
            </div>
            
            <form action="{{ route('profile.setup') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem;">Nombre de la Empresa</label>
                    <input type="text" name="company_name" required style="width: 100%; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.75rem 1rem; outline: none; transition: all 0.2s;" placeholder="Ej. Mi Bodega S.A.">
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 0.75rem;">Elige tu Avatar (Opcional)</label>
                    <div style="display: flex; justify-content: space-between; padding: 0 0.5rem;">
                        <label style="cursor: pointer; position: relative;">
                            <input type="radio" name="avatar" value="fox" style="position: absolute; opacity: 0; width: 0; height: 0;" onchange="updateSelectedAvatar(this)">
                            <div class="avatar-option" style="width: 3.5rem; height: 3.5rem; border-radius: 50%; border: 4px solid transparent; background-color: #ffedd5; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; transition: transform 0.2s;">🦊</div>
                        </label>
                        <label style="cursor: pointer; position: relative;">
                            <input type="radio" name="avatar" value="cat" style="position: absolute; opacity: 0; width: 0; height: 0;" onchange="updateSelectedAvatar(this)">
                            <div class="avatar-option" style="width: 3.5rem; height: 3.5rem; border-radius: 50%; border: 4px solid transparent; background-color: #dbeafe; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; transition: transform 0.2s;">🐱</div>
                        </label>
                        <label style="cursor: pointer; position: relative;">
                            <input type="radio" name="avatar" value="dog" style="position: absolute; opacity: 0; width: 0; height: 0;" onchange="updateSelectedAvatar(this)">
                            <div class="avatar-option" style="width: 3.5rem; height: 3.5rem; border-radius: 50%; border: 4px solid transparent; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; transition: transform 0.2s;">🐶</div>
                        </label>
                        <label style="cursor: pointer; position: relative;">
                            <input type="radio" name="avatar" value="panda" style="position: absolute; opacity: 0; width: 0; height: 0;" onchange="updateSelectedAvatar(this)">
                            <div class="avatar-option" style="width: 3.5rem; height: 3.5rem; border-radius: 50%; border: 4px solid transparent; background-color: #fce7f3; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; transition: transform 0.2s;">🐼</div>
                        </label>
                    </div>
                </div>
                
                <button type="submit" style="width: 100%; background-color: #2563eb; color: white; font-weight: 500; padding: 0.75rem; border-radius: 0.5rem; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background-color 0.2s; margin-top: 0.5rem;">
                    Comenzar a usar el sistema <i data-lucide="arrow-right" style="width: 1rem; height: 1rem;"></i>
                </button>
            </form>
        </div>
    </div>
    <script>
        function updateSelectedAvatar(radio) {
            document.querySelectorAll('.avatar-option').forEach(el => el.style.borderColor = 'transparent');
            if(radio.checked) {
                radio.nextElementSibling.style.borderColor = '#3b82f6';
            }
        }
    </script>
    @endif
</body>
</html>
