<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->orderBy('id', 'desc')->get();
        $products = auth()->user()->products()->where('stock', '>', 0)->get();
        return view('orders.index', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'nullable|string|max:255',
            'total' => 'required|numeric|min:0',
            'cart_items' => 'nullable|array',
            'status' => 'nullable|string'
        ]);

        $order = auth()->user()->orders()->create([
            'customer' => $request->customer ?? 'Cliente General',
            'total' => $request->total,
            'status' => $request->status ?? 'Completado',
            'cart_items' => $request->cart_items,
        ]);

        if (is_array($request->cart_items)) {
            foreach ($request->cart_items as $item) {
                if (isset($item['name'])) {
                    $product = auth()->user()->products()->where('name', $item['name'])->first();
                    if ($product) {
                        $product->movements()->create([
                            'type' => 'exit',
                            'quantity' => 1, // El carrito frontend agrega 1 por click
                            'description' => 'Venta en Pedido #' . $order->id,
                        ]);
                        $product->updateStockFromMovements();
                    }
                }
            }
        }

        return response()->json(['success' => true, 'order' => $order]);
    }
}
