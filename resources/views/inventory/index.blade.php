<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - ValleStock</title>
    <!-- Tailwind CSS para la estructura base e incrustación de tu CSS -->
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

        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); min-height: 100vh; }
        .font-display { font-family: 'Outfit', sans-serif; }

        /* Sidebar Styles (Idénticos a Dashboard) */
        .sidebar { width: 250px; background-color: var(--sidebar-bg); color: var(--sidebar-text); min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar-header { padding: 1.5rem; display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .sidebar-logo-box { background-color: var(--brand-secondary); padding: 0.5rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; }
        .sidebar-nav { padding: 1.5rem 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .nav-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.5rem; color: var(--sidebar-text); text-decoration: none; transition: all 0.2s; font-weight: 500; }
        .nav-item:hover, .nav-item.active { background-color: rgba(255, 255, 255, 0.1); color: var(--sidebar-active-text); }
        
        /* Header Styles */
        .header { background-color: #ffffff; padding: 1.25rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }

        /* --- TUS CLASES CSS PARA INVENTARIO --- */
        .data-table-container { background-color: white; border-radius: 1rem; border: 1px solid var(--border-color); overflow: auto; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .data-table { width: 100%; text-align: left; border-collapse: collapse; min-width: 800px; }
        .data-table th { background-color: #f8fafc; padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border-color); }
        .data-table td { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; }
        
        /* Badges de Estado */
        .badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; border: 1px solid transparent; display: inline-block; text-align: center; }
        .badge-success { background-color: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .badge-warning { background-color: #fff7ed; color: #c2410c; border-color: #fed7aa; }
        .badge-danger { background-color: #fef2f2; color: #b91c1c; border-color: #fecaca; }
        
        .input-field { width: 100%; border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; background-color: white; transition: all 0.2s; }
        .input-field:focus { outline: none; border-color: var(--brand-secondary); box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1); }
        
        .btn-outline { background-color: white; border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; font-weight: 500; color: var(--text-main); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s; white-space: nowrap; }
        .btn-outline:hover { background-color: #f8fafc; border-color: #cbd5e1; }
        
        .product-img-placeholder { width: 2.5rem; height: 2.5rem; background-color: #f1f5f9; border-radius: 0.5rem; display:flex; align-items:center; justify-content:center; color: #94a3b8;}
        .sku-code { font-family: monospace; font-size: 0.75rem; color: #64748b; background-color: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 0.25rem; }
        
        .btn-action { padding: 0.375rem 0.75rem; color: #2563eb; border: 1px solid #bfdbfe; background-color: transparent; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .btn-action:hover { background-color: #eff6ff; }
        .btn-action-danger { padding: 0.375rem 0.75rem; color: #ef4444; border: 1px solid #fecaca; background-color: transparent; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s; }
        .btn-action-danger:hover { background-color: #fef2f2; }
        
        .btn-primary { background-color: var(--brand-secondary); color: white; border: none; border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; gap: 0.5rem; }
        .btn-primary:hover { background-color: #2563eb; }
    </style>
</head>
<body class="flex">
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.png') }}" alt="ValleStock Logo" style="height: 38px; width: auto; object-fit: contain;">
            <span class="font-display" style="color: white; font-weight: 700; font-size: 1.25rem;">ValleStock</span>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item"><i data-lucide="layout-dashboard"></i> Panel de Control</a>
            <a href="{{ route('inventory.index') }}" class="nav-item active"><i data-lucide="package"></i> Inventario</a>
            <a href="{{ route('orders.index') }}" class="nav-item"><i data-lucide="shopping-cart"></i> Pedidos</a>
            <a href="{{ route('reports.index') }}" class="nav-item"><i data-lucide="bar-chart-3"></i> Informes</a>
            <a href="{{ route('settings.index') }}" class="nav-item"><i data-lucide="settings"></i> Configuración</a>
        </nav>
    </aside>

    <main class="flex-1 overflow-x-hidden">
        <header class="header">
            <h1 class="font-display" style="font-size: 1.5rem; font-weight: 700;">Gestión de Inventario</h1>
            
            <div class="flex items-center gap-4">
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

        <div class="p-8">
            <!-- Header de Acciones -->
            <div class="flex flex-wrap gap-4 justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold font-display text-slate-800">Catálogo de Productos</h2>
                    <p class="text-sm text-slate-500">Gestiona todos los artículos disponibles en el almacén</p>
                </div>
                <button class="btn-primary" onclick="openProductModal()">
                    <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                    Añadir Producto
                </button>
            </div>

            <!-- Filtros y Búsqueda -->
            <div class="flex flex-wrap gap-4 mb-6">
                <div style="flex: 1; min-width: 250px; position: relative;">
                    <i data-lucide="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; color: #94a3b8;"></i>
                    <input type="text" class="input-field" placeholder="Buscar por nombre..." oninput="filterTable(this.value)" style="padding-left: 2.5rem;">
                </div>
                <button class="btn-outline">
                    <i data-lucide="filter" style="width: 16px; height: 16px;"></i> Filtros
                </button>
                <button class="btn-outline" onclick="exportToCsv()">
                    <i data-lucide="download" style="width: 16px; height: 16px;"></i> Exportar CSV
                </button>
            </div>

            <!-- Tabla de Datos (Construida con tu CSS) -->
            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>SKU</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Precio</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        @foreach($products as $p)
                        <tr>
                            <td class="flex items-center gap-3">
                                <div class="product-img-placeholder"><i data-lucide="image" style="width:16px;"></i></div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $p->name }}</p>
                                    <p class="text-xs text-slate-500">Almacén Principal</p>
                                </div>
                            </td>
                            <td><span class="sku-code">{{ $p->sku }}</span></td>
                            <td class="text-sm text-slate-600">{{ $p->cat }}</td>
                            <td class="font-bold text-sm {{ $p->stock == 0 ? 'text-red-600' : ($p->stock <= 10 ? 'text-orange-500' : 'text-slate-900') }}">{{ $p->stock }}</td>
                            <td>
                                @if($p->stock == 0)
                                    <span class="badge badge-danger">Agotado</span>
                                @elseif($p->stock <= 10)
                                    <span class="badge badge-warning">Stock Bajo</span>
                                @else
                                    <span class="badge badge-success">Disponible</span>
                                @endif
                            </td>
                            <td class="text-sm font-medium">${{ number_format($p->price, 2) }}</td>
                            <td class="text-right flex justify-end gap-2" style="white-space: nowrap;">
                                <button class="btn-action" onclick="editProduct({{ $p->id }})">Editar</button>
                                <form action="{{ route('inventory.destroy', $p->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres borrar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 flex justify-between items-center text-sm text-slate-500">
                <p id="paginationInfo">Mostrando 0 resultados</p>
                <div class="flex gap-2">
                    <button class="btn-outline" style="padding: 0.25rem 0.75rem;" disabled>Anterior</button>
                    <button class="btn-outline" style="padding: 0.25rem 0.75rem;">Siguiente</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Añadir/Editar Producto -->
    <div id="productModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
        <div style="background: white; border-radius: 1.5rem; width: 100%; max-width: 500px; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <h2 id="productModalTitle" class="text-xl font-display font-bold text-slate-900 mb-4">Añadir Producto</h2>
            <form id="productForm" method="POST" action="{{ route('inventory.store') }}">
                @csrf
                <input type="hidden" name="_method" id="method_field" value="POST">
                <input type="hidden" id="editProductId">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Nombre</label>
                        <input type="text" name="name" id="prodName" required class="input-field" placeholder="Ej. Teclado Mecánico">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">SKU</label>
                            <input type="text" name="sku" id="prodSku" required class="input-field" placeholder="PRD-000">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Categoría</label>
                            <input type="text" name="cat" id="prodCat" required class="input-field" placeholder="Accesorios">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Stock</label>
                            <input type="number" name="stock" id="prodStock" required class="input-field" placeholder="0">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Precio ($)</label>
                            <input type="number" name="price" id="prodPrice" step="0.01" required class="input-field" placeholder="0.00">
                        </div>
                    </div>
                </div>
                <div class="flex gap-4 mt-6">
                    <button type="button" class="btn-outline flex-1" onclick="closeProductModal()">Cancelar</button>
                    <button type="submit" class="btn-primary flex-1 justify-center">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        let products = @json($products);

        function filterTable(val) {
            const lower = val.toLowerCase();
            const rows = document.querySelectorAll('#inventoryTableBody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if(text.includes(lower)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function openProductModal() {
            document.getElementById('productForm').reset();
            document.getElementById('editProductId').value = '';
            document.getElementById('productForm').action = "{{ route('inventory.store') }}";
            document.getElementById('method_field').value = "POST";
            document.getElementById('productModalTitle').innerText = 'Añadir Producto';
            document.getElementById('productModal').style.display = 'flex';
        }

        function closeProductModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        function editProduct(id) {
            const p = products.find(prod => prod.id === id);
            if(!p) return;
            document.getElementById('editProductId').value = p.id;
            document.getElementById('prodName').value = p.name;
            document.getElementById('prodSku').value = p.sku;
            document.getElementById('prodCat').value = p.cat;
            document.getElementById('prodStock').value = p.stock;
            document.getElementById('prodPrice').value = p.price;
            document.getElementById('productModalTitle').innerText = 'Editar Producto';
            
            document.getElementById('productForm').action = "/inventory/" + id;
            document.getElementById('method_field').value = "PUT";
            
            document.getElementById('productModal').style.display = 'flex';
        }

        function exportToCsv() {
            if (products.length === 0) {
                alert("No hay datos para exportar.");
                return;
            }
            const headers = ['ID', 'Nombre', 'SKU', 'Categoría', 'Stock', 'Precio'];
            const rows = products.map(p => [
                p.id,
                `"${p.name.replace(/"/g, '""')}"`,
                p.sku,
                `"${p.cat}"`,
                p.stock,
                p.price
            ]);
            let csvContent = headers.join(',') + '\n' + rows.map(e => e.join(',')).join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "inventario_vallestock.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>
