<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ─── Stat Cards ───────────────────────────────────────────────────────
        $stats = [
            'total_revenue'   => Order::where('status', 'completed')->sum('total_price'),
            'total_orders'    => Order::count(),
            'total_products'  => Product::count(),
            'total_users'     => User::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'pending_custom'  => CustomOrder::where('status', 'pending')->count(),
            'unread_messages' => Message::whereNull('read_at')->where('is_reply', false)->count(),
        ];

        // ─── Revenue last 7 days ──────────────────────────────────────────────
        $revenueChart = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(6))
            ->selectRaw("DATE(created_at) as date, SUM(total_price) as total")
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $chartLabels = collect(range(6, 0))->map(fn($d) => now()->subDays($d)->format('Y-m-d'));
        $chartData   = $chartLabels->map(fn($d) => $revenueChart[$d] ?? 0);

        // ─── Order status distribution ────────────────────────────────────────
        $orderStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // ─── Recent orders ────────────────────────────────────────────────────
        $recentOrders = Order::with('product')
            ->latest()
            ->take(8)
            ->get();

        // ─── Recent custom orders ─────────────────────────────────────────────
        $recentCustomOrders = CustomOrder::latest()->take(5)->get();

        // ─── Recent messages ──────────────────────────────────────────────────
        $recentMessages = Message::where('is_reply', false)
            ->latest()
            ->take(5)
            ->get();

        // ─── Top products ─────────────────────────────────────────────────────
        $topProducts = Product::withCount('images')
            ->withSum(['orders as total_sold' => fn($q) => $q->where('status', 'completed')], 'qty')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'chartLabels', 'chartData',
            'orderStatus', 'recentOrders', 'recentCustomOrders',
            'recentMessages', 'topProducts'
        ));
    }
}
