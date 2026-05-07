<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index(Request $request)
    {
        $products   = $this->service->getAll($request->only('search', 'category_id', 'is_available'));
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $images = $request->hasFile('images') ? $request->file('images') : [];
        $this->service->create($request->validated(), $images);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::orderBy('name')->get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $images = $request->hasFile('images') ? $request->file('images') : [];
        $this->service->update($product, $request->validated(), $images);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $this->service->delete($product);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function setPrimaryImage(Request $request, Product $product)
    {
        $request->validate(['image_id' => ['required', 'exists:product_images,id']]);
        $this->service->setPrimaryImage($product, $request->image_id);
        return back()->with('success', 'Foto utama berhasil diubah.');
    }

    public function deleteImage(ProductImage $image)
    {
        $this->service->deleteImage($image);
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
