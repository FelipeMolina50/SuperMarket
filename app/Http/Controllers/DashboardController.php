<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = auth()->user()->orders()->count();
        $totalRevenue = auth()->user()->orders()->sum('total');
        $lowStockProducts = auth()->user()->products()->where('stock', '<', 10)->count();

        return view('dashboard', compact('totalOrders', 'totalRevenue', 'lowStockProducts'));
    }

    public function reports()
    {
        $orders = auth()->user()->orders()->orderBy('date', 'asc')->get();
        $products = auth()->user()->products()->get();

        return view('reports.index', compact('orders', 'products'));
    }
}
