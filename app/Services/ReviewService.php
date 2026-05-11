<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    /**
     * Cek apakah user boleh review produk ini
     * — harus punya order completed untuk produk ini
     * — belum pernah review order yang sama
     */
    public function canReview(Product $product): array
    {
        if (!Auth::check()) {
            return ['can' => false, 'reason' => 'login', 'order' => null];
        }

        // Cari order completed milik user untuk produk ini
        $order = Order::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('status', 'completed')
            ->first();

        if (!$order) {
            return ['can' => false, 'reason' => 'no_purchase', 'order' => null];
        }

        // Cek sudah pernah review order ini
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($alreadyReviewed) {
            return ['can' => false, 'reason' => 'already_reviewed', 'order' => $order];
        }

        return ['can' => true, 'reason' => null, 'order' => $order];
    }

    public function store(Product $product, Order $order, int $rating, ?string $body): Review
    {
        return Review::create([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
            'order_id'   => $order->id,
            'rating'     => $rating,
            'body'       => $body,
            'is_visible' => true,
        ]);
    }

    public function getForProduct(Product $product, int $perPage = 5)
    {
        return Review::with('user')
            ->where('product_id', $product->id)
            ->where('is_visible', true)
            ->latest()
            ->paginate($perPage);
    }

    public function getRatingBreakdown(Product $product): array
    {
        $total = Review::where('product_id', $product->id)->where('is_visible', true)->count();
        $breakdown = [];

        for ($i = 5; $i >= 1; $i--) {
            $count = Review::where('product_id', $product->id)
                ->where('is_visible', true)
                ->where('rating', $i)
                ->count();
            $breakdown[$i] = [
                'count'   => $count,
                'percent' => $total > 0 ? round(($count / $total) * 100) : 0,
            ];
        }

        return $breakdown;
    }
}
