<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class WelcomeService
{
    public function getFeaturedProduct(): ?Product
    {
        return Product::with(['primaryImage', 'category'])
            ->where('is_available', true)
            ->where('is_best', true)
            ->latest()
            ->first();
    }

    public function getBestSellers(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with(['primaryImage', 'category'])
            ->where('is_available', true)
            ->where('is_best', true)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::whereNull('parent_id')
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();
    }

    public function getNewArrivals(int $limit = 4): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with(['primaryImage', 'category'])
            ->where('is_available', true)
            ->latest()
            ->take($limit)
            ->get();
    }
}
