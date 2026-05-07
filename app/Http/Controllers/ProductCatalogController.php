<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductCatalogController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $categories = Category::whereNull('parent_id')->where('is_active', true)->withCount('products')->get();

        $products = Product::with(['primaryImage', 'category'])
            ->where('is_available', true)
            ->when($request->category, fn($q) => $q->whereHas('category', fn($q2) => $q2->where('slug', $request->category)))
            ->when($request->search, fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->when($request->sort === 'price_asc',  fn($q) => $q->orderBy('price'))
            ->when($request->sort === 'price_desc', fn($q) => $q->orderByDesc('price'))
            ->when($request->sort === 'newest' || !$request->sort, fn($q) => $q->latest())
            ->paginate(12)->withQueryString();

        $activeCategory = $request->category
            ? Category::where('slug', $request->category)->first()
            : null;

        return view('store.products', compact('products', 'categories', 'activeCategory'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_available, 404);
        $product->load(['images', 'category']);

        $related = Product::with('primaryImage')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->take(4)->get();

        return view('store.product-detail', compact('product', 'related'));
    }
}
