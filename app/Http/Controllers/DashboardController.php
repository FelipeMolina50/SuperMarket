<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');
        $lowStockProducts = Product::where('stock', '<', 10)->count();

        return view('dashboard', compact('totalOrders', 'totalRevenue', 'lowStockProducts'));
    }

    public function reports()
    {
        $orders = Order::orderBy('date', 'asc')->get();
        $products = Product::all();

        return view('reports.index', compact('orders', 'products'));
    }
}
