<?php

namespace App\Services;

use App\Models\CustomOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomOrderService
{
    public function getAll(array $filters = [])
    {
        return CustomOrder::with(['user', 'product'])
            ->when(!empty($filters['search']), fn($q) =>
                $q->where('subject', 'like', '%'.$filters['search'].'%')
                  ->orWhere('customer_email', 'like', '%'.$filters['search'].'%')
            )
            ->when(!empty($filters['status']), fn($q) => $q->where('status', $filters['status']))
            ->when(!empty($filters['type']), fn($q) => $q->where('type', $filters['type']))
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }

    public function updateStatus(CustomOrder $customOrder, string $status): CustomOrder
    {
        $data = ['status' => $status];
        if ($status === 'completed') {
            $data['fulfilled_by'] = Auth::guard('admin')->id();
        }
        $customOrder->update($data);
        return $customOrder;
    }

    public function setEstimatedPrice(CustomOrder $customOrder, float $price): CustomOrder
    {
        $customOrder->update(['estimated_price' => $price]);
        return $customOrder;
    }

    public function delete(CustomOrder $customOrder): void
    {
        if ($customOrder->reference_file) {
            Storage::disk('public')->delete($customOrder->reference_file);
        }
        $customOrder->delete();
    }
}
