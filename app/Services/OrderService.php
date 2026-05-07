<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class OrderService
{
    public function getAll(array $filters = [])
    {
        return Order::with(['user', 'product'])
            ->when(!empty($filters['search']), fn($q) =>
                $q->where('customer_name', 'like', '%'.$filters['search'].'%')
                  ->orWhere('customer_email', 'like', '%'.$filters['search'].'%')
            )
            ->when(!empty($filters['status']), fn($q) => $q->where('status', $filters['status']))
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);
        return $order;
    }

    public function uploadPaymentProof(Order $order, $file): Order
    {
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }
        $path = $file->store('proofs', 'public');
        $order->update(['payment_proof' => $path]);
        return $order;
    }

    public function delete(Order $order): void
    {
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }
        $order->delete();
    }
}
