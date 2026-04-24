<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - ValleStock</title>
    <!-- Tailwind CSS para la estructura general -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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
        .search-bar { background-color: #f1f5f9; border: 1px solid transparent; border-radius: 9999px; padding: 0.5rem 1rem 0.5rem 2.5rem; font-size: 0.875rem; outline: none; transition: all 0.2s; width: 250px; }
        .search-bar:focus { background-color: #ffffff; border-color: var(--brand-secondary); box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2); }

        /* General UI Classes */
        .btn-outline { background-color: white; border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; font-weight: 500; color: var(--text-main); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s; }
        .btn-outline:hover { background-color: #f8fafc; border-color: #cbd5e1; }
        .btn-primary-blue { background-color: var(--brand-secondary); color: white; border: none; border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        .btn-primary-blue:hover { background-color: #2563eb; }
        .input-field { width: 100%; border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.875rem; background-color: white; transition: all 0.2s; }
        .input-field:focus { outline: none; border-color: var(--brand-secondary); box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1); }

        /* Tables & Badges */
        .data-table-container { background-color: white; border-radius: 1rem; border: 1px solid var(--border-color); overflow: auto; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .data-table { width: 100%; text-align: left; border-collapse: collapse; min-width: 800px; }
        .data-table th { background-color: #f8fafc; padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border-color); }
        .data-table td { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; }
        .badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; border: 1px solid transparent; display: inline-block; text-align: center; }
        .badge-success { background-color: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .badge-warning { background-color: #fff7ed; color: #c2410c; border-color: #fed7aa; }

        /* Orders Specific Styles (FROM USER) */
        .modal-backdrop { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 1rem; }
        .modal-content { background: white; border-radius: 1.5rem; width: 100%; max-width: 900px; max-height: 90vh; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .modal-header { padding: 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; background: #f8fafc; }
        .modal-body { flex: 1; overflow-y: auto; padding: 1.5rem; }
        
        .product-selection-grid { display: grid; grid-template-columns: 1fr 350px; gap: 2rem; }
        @media (max-width: 768px) {
            .product-selection-grid { grid-template-columns: 1fr; }
        }
        .product-item-card { padding: 1rem; border: 1px solid var(--border-color); border-radius: 1rem; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem; transition: all 0.2s; background: white;}
        .product-item-card:hover { border-color: var(--brand-secondary); background: #f0f9ff; }
        
        .order-summary-panel { background: #f8fafc; border-radius: 1.5rem; padding: 1.5rem; display: flex; flex-direction: column; }
        .payment-method-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem; }
        .payment-option { padding: 1.5rem; border: 2px solid var(--border-color); border-radius: 1.25rem; display: flex; flex-direction: column; align-items: center; gap: 0.75rem; cursor: pointer; transition: all 0.2s; background: white;}
        .payment-option.active { border-color: var(--brand-secondary); background: #eff6ff; color: var(--brand-secondary); }
        
        .invoice-box { border: 2px dashed var(--border-color); border-radius: 1.5rem; padding: 2rem; background: white; }
        .barcode-container { background: #f1f5f9; padding: 1rem; border-radius: 0.75rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; margin-top: 2rem; }
        .barcode-mock { width: 200px; height: 40px; background: repeating-linear-gradient( 90deg, #000, #000 2px, #fff 2px, #fff 4px ); }
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
            <a href="{{ route('orders.index') }}" class="nav-item active"><i data-lucide="shopping-cart"></i> Pedidos</a>
            <a href="{{ route('reports.index') }}" class="nav-item"><i data-lucide="bar-chart-3"></i> Informes</a>
            <a href="{{ route('settings.index') }}" class="nav-item"><i data-lucide="settings"></i> Configuración</a>
        </nav>
    </aside>

    <main class="flex-1 overflow-x-hidden">
        <header class="header">
            <h1 class="text-2xl font-display font-bold text-slate-900">Gestión de Pedidos</h1>
            <div class="flex items-center gap-6">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" placeholder="Buscar pedidos..." class="search-bar">
                </div>
                
                {{-- Dropdown de Perfil Integrado --}}
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

        <div class="p-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex gap-4">
                    <button class="btn-outline border-blue-500 text-blue-600">Todos los Pedidos</button>
                    <button class="btn-outline" style="color: #64748b;">Pendientes</button>
                </div>
                <div class="flex gap-3">
                    <button class="btn-primary-blue" style="width: auto; padding: 0.625rem 1.5rem;" onclick="openModal()">
                        <i data-lucide="plus" class="w-4 h-4"></i> Añadir Pedido
                    </button>
                    <button class="btn-outline" style="width: auto; padding: 0.625rem 1.5rem;" onclick="exportOrdersCsv()">
                        <i data-lucide="download" class="w-4 h-4"></i> Exportar CSV
                    </button>
                </div>
            </div>

            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID de Pedido</th><th>Cliente</th><th>Fecha</th><th>Total</th><th>Estado</th><th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        @foreach($orders as $order)
                        <tr>
                            <td class="text-sm font-bold" style="color: #2563eb;">{{ $order->id }}</td>
                            <td class="text-sm font-medium">{{ $order->customer }}</td>
                            <td class="text-sm text-slate-500">{{ $order->date }}</td>
                            <td class="text-sm font-bold">${{ number_format($order->total, 2) }}</td>
                            <td><span class="badge {{ $order->status === 'Completado' ? 'badge-success' : 'badge-warning' }}">{{ $order->status }}</span></td>
                            <td style="text-align: center;">
                                <div class="flex justify-center gap-2">
                                    <i data-lucide="printer" class="w-4 h-4 text-slate-400 cursor-pointer hover:text-blue-500"></i>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal de Nuevo Pedido -->
    <div id="orderModal" class="modal-backdrop">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle" class="text-xl font-display font-bold text-slate-900">Seleccionar Productos</h2>
                <button onclick="closeModal()" style="background: none; border: none; cursor: pointer;">
                    <i data-lucide="x" class="w-6 h-6 text-slate-400 hover:text-slate-600"></i>
                </button>
            </div>

            <div class="modal-body">
                <!-- Paso 1: Selección -->
                <div id="stepSelection" class="product-selection-grid">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-slate-700">Productos Disponibles</h3>
                            <div class="flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full border border-blue-100">
                                <i data-lucide="barcode" class="w-4 h-4"></i>
                                <span class="text-xs font-bold">Escáner Físico Activo</span>
                            </div>
                        </div>
                        @foreach($products as $prod)
                        <div class="product-item-card">
                            <div>
                                <p class="font-bold">{{ $prod->name }}</p>
                                <p class="text-sm text-slate-500">${{ number_format($prod->price, 2) }} • Stock: {{ $prod->stock }}</p>
                            </div>
                            <button class="btn-primary-blue" style="width: 40px; height: 40px; padding: 0; flex-shrink: 0;" onclick="addToCart('{{ $prod->name }}', {{ $prod->price }})">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <div class="order-summary-panel">
                        <h3 class="font-bold text-slate-700 mb-4">Resumen</h3>
                        <div id="cartItems" class="flex-1 space-y-3 min-h-[150px]">
                            <p class="text-center text-slate-400 py-8">Carrito vacío</p>
                        </div>
                        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                            <div class="flex justify-between mb-4">
                                <span class="text-slate-500">Total</span>
                                <span id="totalDisplay" class="text-2xl font-bold text-slate-900">$0.00</span>
                            </div>
                            <button class="btn-primary-blue" style="width: 100%;" onclick="goToPayment()">Continuar al Pago</button>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Pago -->
                <div id="stepPayment" style="display: none; max-width: 500px; margin: 0 auto; width: 100%;">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <p class="text-slate-500">Monto a Pagar</p>
                        <h3 id="paymentTotal" class="text-4xl font-bold text-slate-900">$0.00</h3>
                    </div>

                    <div class="payment-method-grid">
                        <div id="payCard" class="payment-option" onclick="selectPayment('card')">
                            <i data-lucide="credit-card" class="w-8 h-8"></i>
                            <span class="font-bold">Tarjeta</span>
                        </div>
                        <div id="payCash" class="payment-option" onclick="selectPayment('cash')">
                            <i data-lucide="banknote" class="w-8 h-8"></i>
                            <span class="font-bold">Efectivo</span>
                        </div>
                    </div>

                    <div id="cardInfo" style="display: none; background: #f8fafc; padding: 1.5rem; border-radius: 1rem; margin-bottom: 1.5rem;">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-slate-500">Saldo en Tarjeta</span>
                            <span class="text-sm font-bold text-slate-900">$5,000.00</span>
                        </div>
                        <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: #2563eb; width: 15%;"></div>
                        </div>
                    </div>

                    <div id="cashInfo" style="display: none; margin-bottom: 1.5rem;">
                        <label class="text-sm font-bold text-slate-700 mb-2 block">Monto Recibido</label>
                        <input type="number" id="cashInput" class="input-field" placeholder="0.00" oninput="calculateChange()">
                        <div id="changeDisplay" style="display: none; margin-top: 1rem; padding: 1rem; background: #f0fdf4; border-radius: 1rem; color: #166534;">
                            <div class="flex justify-between items-center">
                                <span>Cambio:</span>
                                <span id="changeValue" class="text-xl font-bold">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button class="btn-outline" style="flex: 1;" onclick="goToSelection()">Atrás</button>
                        <button class="btn-primary-blue" style="flex: 1;" onclick="finishOrder()">Finalizar Pago</button>
                    </div>
                </div>

                <!-- Paso 3: Factura -->
                <div id="stepInvoice" style="display: none; max-width: 600px; margin: 0 auto; width: 100%;">
                    <div class="invoice-box">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">
                            <div>
                                <h4 class="font-bold">ValleStock</h4>
                                <p class="text-xs text-slate-500">NIT: 900.123.456-1</p>
                            </div>
                            <div style="text-align: right;">
                                <p class="font-bold">FACTURA <span id="facturaDisplay"></span></p>
                                <p class="text-xs text-slate-500">{{ date('d M, Y') }}</p>
                            </div>
                        </div>

                        <div id="invoiceItems" style="margin-bottom: 2rem; min-height: 100px;">
                            <!-- Items will be injected here -->
                        </div>

                        <div style="border-top: 2px solid #f1f5f9; padding-top: 1rem;">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm text-slate-500">Subtotal</span>
                                <span id="invoiceSubtotal" class="text-sm font-bold">$0.00</span>
                            </div>
                            <div class="flex justify-between mb-3">
                                <span class="text-sm text-slate-500">IVA (19%)</span>
                                <span id="invoiceTax" class="text-sm font-bold">$0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-bold text-lg">TOTAL</span>
                                <span id="invoiceTotal" class="font-bold text-lg text-blue-600">$0.00</span>
                            </div>
                        </div>

                        <div class="barcode-container">
                            <div class="barcode-mock"></div>
                            <span class="text-xs font-mono tracking-widest" id="barcodeNumber">7701234567890</span>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button class="btn-outline" style="flex: 1;" onclick="closeModal()">Cerrar</button>
                        <button class="btn-primary-blue" style="flex: 1;" onclick="downloadInvoicePDF()">
                            <i data-lucide="download" class="w-4 h-4"></i> Descargar PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Variables de entorno JS
        let cart = [];
        let total = 0;
        let selectedPayMethod = null;
        
        let orders = @json($orders);
        let productsList = @json($products);

        // Lógica para Escáner de Mano (HID)
        let barcodeBuffer = "";
        let lastKeyTime = Date.now();

        window.addEventListener('keydown', (e) => {
            const currentTime = Date.now();
            if (currentTime - lastKeyTime > 100) {
                barcodeBuffer = "";
            }
            if (e.key === 'Enter') {
                if (barcodeBuffer.length > 2) {
                    processBarcode(barcodeBuffer);
                    barcodeBuffer = "";
                }
            } else if (e.key.length === 1) {
                barcodeBuffer += e.key;
            }
            lastKeyTime = currentTime;
        });

        function processBarcode(code) {
            console.log("Código escaneado:", code);
            const p = productsList.find(prod => prod.sku === code);
            if (p) {
                addToCart(p.name, parseFloat(p.price));
            } else {
                const toast = document.createElement('div');
                toast.style = "position: fixed; bottom: 2rem; right: 2rem; background: #ef4444; color: white; padding: 1rem 2rem; border-radius: 1rem; z-index: 9999; font-weight: bold; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);";
                toast.innerText = `Producto no encontrado (SKU: ${code})`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        }

        function renderOrders() {
            // Already rendered via blade, but if we add new, just reload or prepend.
            // Since we reload page, we can leave this empty or we can keep JS append for realtime UX.
        }

        function openModal() {
            document.getElementById('orderModal').style.display = 'flex';
            goToSelection();
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
            cart = [];
            document.getElementById('cashInput').value = '';
            document.getElementById('changeDisplay').style.display = 'none';
            selectedPayMethod = null;
            document.getElementById('payCard').classList.remove('active');
            document.getElementById('payCash').classList.remove('active');
            updateCartUI();
        }

        function addToCart(name, price) {
            cart.push({ name, price });
            updateCartUI();
            
            // Efecto visual simple
            const toast = document.createElement('div');
            toast.style = "position: fixed; bottom: 2rem; right: 2rem; background: #22c55e; color: white; padding: 1rem 2rem; border-radius: 1rem; z-index: 9999; font-weight: bold;";
            toast.innerText = `${name} añadido al carrito`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        }

        function updateCartUI() {
            const container = document.getElementById('cartItems');
            if (cart.length === 0) {
                container.innerHTML = '<p class="text-center text-slate-400 py-8">Carrito vacío</p>';
                total = 0;
            } else {
                container.innerHTML = cart.map((item, index) => `
                    <div class="flex justify-between items-center bg-white p-3 rounded-xl shadow-sm border border-slate-100">
                        <span class="text-sm font-medium">${item.name}</span>
                        <span class="text-sm font-bold">$${item.price.toFixed(2)}</span>
                    </div>
                `).join('');
                total = cart.reduce((sum, item) => sum + item.price, 0);
            }
            document.getElementById('totalDisplay').innerText = `$${total.toFixed(2)}`;
            document.getElementById('paymentTotal').innerText = `$${total.toFixed(2)}`;
        }

        function goToSelection() {
            document.getElementById('modalTitle').innerText = 'Seleccionar Productos';
            document.getElementById('stepSelection').style.display = 'grid';
            document.getElementById('stepPayment').style.display = 'none';
            document.getElementById('stepInvoice').style.display = 'none';
        }

        function goToPayment() {
            if (cart.length === 0) {
                alert('Seleccione al menos un producto');
                return;
            }
            document.getElementById('modalTitle').innerText = 'Procesar Pago';
            document.getElementById('stepSelection').style.display = 'none';
            document.getElementById('stepPayment').style.display = 'block';
            document.getElementById('stepInvoice').style.display = 'none';
            lucide.createIcons();
        }

        function selectPayment(method) {
            selectedPayMethod = method;
            document.getElementById('payCard').classList.toggle('active', method === 'card');
            document.getElementById('payCash').classList.toggle('active', method === 'cash');
            document.getElementById('cardInfo').style.display = method === 'card' ? 'block' : 'none';
            document.getElementById('cashInfo').style.display = method === 'cash' ? 'block' : 'none';
            if (method === 'cash') calculateChange();
        }

        function calculateChange() {
            const received = parseFloat(document.getElementById('cashInput').value) || 0;
            const changeDisplay = document.getElementById('changeDisplay');
            if (received >= total && total > 0) {
                changeDisplay.style.display = 'block';
                document.getElementById('changeValue').innerText = `$${(received - total).toFixed(2)}`;
            } else {
                changeDisplay.style.display = 'none';
            }
        }

        function finishOrder() {
            if (!selectedPayMethod) {
                alert('Seleccione un método de pago');
                return;
            }
            
            if (selectedPayMethod === 'cash') {
                const received = parseFloat(document.getElementById('cashInput').value) || 0;
                if (received < total) {
                    alert('Monto recibido insuficiente');
                    return;
                }
            }

            document.getElementById('modalTitle').innerText = 'Factura Generada';
            document.getElementById('stepPayment').style.display = 'none';
            document.getElementById('stepInvoice').style.display = 'block';

            // Generar Factura
            const invoiceItems = document.getElementById('invoiceItems');
            invoiceItems.innerHTML = cart.map(item => `
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-600">${item.name}</span>
                    <span class="font-bold">$${item.price.toFixed(2)}</span>
                </div>
            `).join('');

            const tax = total * 0.19; // IVA ejemplo 19%
            document.getElementById('invoiceSubtotal').innerText = `$${(total - tax).toFixed(2)}`;
            document.getElementById('invoiceTax').innerText = `$${tax.toFixed(2)}`;
            document.getElementById('invoiceTotal').innerText = `$${total.toFixed(2)}`;
            
            // Guardar pedido
            const orderId = `ORD-${Math.floor(1000 + Math.random() * 9000)}`;
            document.getElementById('facturaDisplay').innerText = `#${orderId.replace('ORD-', '')}`;
            document.getElementById('barcodeNumber').innerText = Math.floor(Math.random() * 10000000000000).toString().padStart(13, '0');

            // Formato de fecha corto
            const today = new Date();
            const dateStr = today.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });

            const newOrder = {
                customer: 'Cliente General',
                total: total,
                status: 'Completado',
                cart_items: cart,
                _token: '{{ csrf_token() }}'
            };

            fetch('{{ route("orders.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(newOrder)
            }).then(() => {
                setTimeout(() => window.location.reload(), 1500); // recarga para ver el cambio
            });

            lucide.createIcons();
        }

        function exportOrdersCsv() {
            if (orders.length === 0) {
                alert("No hay pedidos para exportar.");
                return;
            }
            const headers = ['ID Pedido', 'Cliente', 'Fecha', 'Total', 'Estado'];
            const rows = orders.map(o => [
                o.id,
                `"${o.customer}"`,
                o.date,
                o.total,
                o.status
            ]);
            let csvContent = headers.join(',') + '\n' + rows.map(e => e.join(',')).join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "pedidos_vallestock.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function downloadInvoicePDF() {
            const element = document.querySelector('.invoice-box');
            const invoiceId = document.getElementById('facturaDisplay').innerText.trim() || "Factura";
            
            const opt = {
                margin:       0.5,
                filename:     `Factura_${invoiceId}_ValleStock.pdf`,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // Mostrar estado de carga temporal
            const btn = event.currentTarget;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader" class="animate-spin w-4 h-4"></i> Generando PDF...';
            lucide.createIcons();
            
            html2pdf().set(opt).from(element).save().then(() => {
                btn.innerHTML = originalText;
                lucide.createIcons();
            });
        }
    </script>
</body>
</html>
