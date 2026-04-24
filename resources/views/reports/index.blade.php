<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes - ValleStock</title>
    <!-- Tailwind CSS para la estructura general -->
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

        .btn-outline { background-color: white; border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; font-weight: 500; color: var(--text-main); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s; }
        .btn-outline:hover { background-color: #f8fafc; border-color: #cbd5e1; }

        .badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; border: 1px solid transparent; display: inline-block; text-align: center; }
        .badge-success { background-color: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .badge-danger { background-color: #fef2f2; color: #b91c1c; border-color: #fecaca; }

        /* Report Specific Styles */
        .stat-card { background-color: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border-color); display: flex; flex-direction: column; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .chart-container { background-color: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
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
            <a href="{{ route('reports.index') }}" class="nav-item active"><i data-lucide="bar-chart-3"></i> Informes</a>
            <a href="{{ route('settings.index') }}" class="nav-item"><i data-lucide="settings"></i> Configuración</a>
        </nav>
    </aside>

    <main class="flex-1 overflow-x-hidden p-0 m-0">
        <header class="header">
            <h1 class="text-2xl font-display font-bold text-slate-900">Análisis e Informes</h1>
            <div class="flex items-center gap-4">
                <button class="btn-outline">
                    <i data-lucide="calendar" class="w-4 h-4"></i> Últimos 6 Meses
                </button>
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
            </div>
        </header>

        <div class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Data will optionally be populated dynamically, static for now -->
                <div class="stat-card gap-4">
                    <p class="text-sm font-medium text-slate-500">Ingresos Totales (Desde Pedidos)</p>
                    <div class="flex items-end justify-between w-full">
                        <h4 class="text-3xl font-bold text-slate-900" id="totalRevDisplay">$328,000</h4>
                        <div class="badge badge-success">+12.5%</div>
                    </div>
                    <p class="text-xs text-slate-400">Calculado localmente</p>
                </div>
                <div class="stat-card gap-4">
                    <p class="text-sm font-medium text-slate-500">Pedidos Totales</p>
                    <div class="flex items-end justify-between w-full">
                        <h4 class="text-3xl font-bold text-slate-900" id="totalOrdersDisplay">156</h4>
                        <div class="badge badge-success">+8.2%</div>
                    </div>
                    <p class="text-xs text-slate-400">Calculado localmente</p>
                </div>
                <div class="stat-card gap-4">
                    <p class="text-sm font-medium text-slate-500">Rotación de Inventario</p>
                    <div class="flex items-end justify-between w-full">
                        <h4 class="text-3xl font-bold text-slate-900">4.2x</h4>
                        <div class="badge badge-danger">-2.1%</div>
                    </div>
                    <p class="text-xs text-slate-400">vs. 6 meses anteriores</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="chart-container lg:col-span-2">
                    <h3 class="text-lg font-bold text-slate-900 mb-8">Ingresos vs Beneficio</h3>
                    <div style="height: 320px; position: relative;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                <div class="chart-container lg:col-span-1">
                    <h3 class="text-lg font-bold text-slate-900 mb-8">Inventario por Categoría</h3>
                    <div style="height: 256px; position: relative;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();

        // Extraer los ingresos reales
        const ordersData = @json($orders);
        if (ordersData.length > 0) {
            const sum = ordersData.reduce((acc, order) => acc + parseFloat(order.total || 0), 0);
            document.getElementById('totalRevDisplay').innerText = `$${sum.toLocaleString('es-ES', {minimumFractionDigits:2, maximumFractionDigits:2})}`;
            document.getElementById('totalOrdersDisplay').innerText = ordersData.length;
        } else {
            document.getElementById('totalRevDisplay').innerText = `$0.00`;
            document.getElementById('totalOrdersDisplay').innerText = 0;
        }

        // Revenue Chart Dinámico
        const revenueMap = {};
        ordersData.forEach(o => {
            const d = String(o.date).substring(0, 6); // Agrupar por ej: '24 Oct'
            revenueMap[d] = (revenueMap[d] || 0) + o.total;
        });
        
        const revLabels = Object.keys(revenueMap).length > 0 ? Object.keys(revenueMap).reverse() : ['Sin Datos'];
        const revData = Object.keys(revenueMap).length > 0 ? Object.values(revenueMap).reverse() : [0];
        const revBen = revData.map(v => v * 0.25); // asumiendo 25% profit
        
        const revCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revCtx, {
            type: 'bar',
            data: {
                labels: revLabels,
                datasets: [
                    {
                        label: 'Ingresos',
                        data: revData,
                        backgroundColor: '#3b82f6',
                        borderRadius: 4
                    },
                    {
                        label: 'Beneficio',
                        data: revBen,
                        backgroundColor: '#6366f1',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } }
            }
        });

        // Category Chart Dinámico
        const productsData = @json($products);
        const categoriasMap = {};
        productsData.forEach(p => {
            categoriasMap[p.cat] = (categoriasMap[p.cat] || 0) + 1;
        });
        const catLabels = Object.keys(categoriasMap).length > 0 ? Object.keys(categoriasMap) : ['Sin Inventario'];
        const catData = Object.keys(categoriasMap).length > 0 ? Object.values(categoriasMap) : [1];
        const catBg = ['#3b82f6', '#6366f1', '#0ea5e9', '#94a3b8', '#10b981', '#f59e0b'];
        
        const catCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catData,
                    backgroundColor: catBg.slice(0, catLabels.length)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                borderWidth: 0
            }
        });
    </script>
</body>
</html>
