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
        
        $dailySales = auth()->user()->orders()
            ->select('date', \DB::raw('SUM(total) as daily_total'), \DB::raw('COUNT(id) as total_orders'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(7)
            ->get();

        return view('dashboard', compact('totalOrders', 'totalRevenue', 'dailySales'));
    }

    public function reports()
    {
        $orders = auth()->user()->orders()->orderBy('date', 'asc')->get();
        $products = auth()->user()->products()->get();

        return view('reports.index', compact('orders', 'products'));
    }
}
