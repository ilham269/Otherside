<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderTrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Daftar semua order milik user
    public function index()
    {
        $orders = Order::with(['product.primaryImage'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Detail & tracking timeline satu order
    public function show(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        $order->load(['product.primaryImage', 'product.category']);

        $timeline = $this->buildTimeline($order);

        return view('orders.show', compact('order', 'timeline'));
    }

    private function buildTimeline(Order $order): array
    {
        $steps = [
            'pending'    => ['label' => 'Pesanan Diterima',        'icon' => 'fa-bag-shopping',    'desc' => 'Pesananmu berhasil dibuat dan menunggu konfirmasi penjual.'],
            'processing' => ['label' => 'Dikonfirmasi & Diproses', 'icon' => 'fa-gear',            'desc' => 'Penjual telah mengkonfirmasi dan sedang memproses pesananmu.'],
            'shipped'    => ['label' => 'Dikirim',                 'icon' => 'fa-truck',           'desc' => 'Pesananmu sedang dalam perjalanan ke alamat tujuan.'],
            'completed'  => ['label' => 'Selesai',                 'icon' => 'fa-circle-check',    'desc' => 'Pesanan telah diterima. Terima kasih sudah berbelanja!'],
            'cancelled'  => ['label' => 'Dibatalkan',              'icon' => 'fa-circle-xmark',    'desc' => 'Pesanan ini telah dibatalkan.'],
        ];

        $flow    = ['pending', 'processing', 'shipped', 'completed'];
        $current = $order->status;

        // Kalau cancelled, hanya tampilkan pending + cancelled
        if ($current === 'cancelled') {
            return [
                array_merge($steps['pending'],    ['status' => 'done']),
                array_merge($steps['cancelled'],  ['status' => 'cancelled']),
            ];
        }

        $currentIndex = array_search($current, $flow);
        $timeline = [];

        foreach ($flow as $i => $step) {
            if ($i < $currentIndex) {
                $state = 'done';
            } elseif ($i === $currentIndex) {
                $state = 'active';
            } else {
                $state = 'upcoming';
            }
            $timeline[] = array_merge($steps[$step], ['status' => $state]);
        }

        return $timeline;
    }
}
