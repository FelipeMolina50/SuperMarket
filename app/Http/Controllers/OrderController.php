<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'nullable|string|max:255',
            'total' => 'required|numeric|min:0',
            'cart_items' => 'nullable|array',
            'status' => 'nullable|string'
        ]);

        $order = Order::create([
            'customer' => $request->customer ?? 'Cliente General',
            'total' => $request->total,
            'status' => $request->status ?? 'Completado',
            'cart_items' => $request->cart_items,
        ]);

        return response()->json(['success' => true, 'order' => $order]);
    }
}
