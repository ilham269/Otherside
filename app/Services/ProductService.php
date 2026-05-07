<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function getAll(array $filters = [])
    {
        return Product::with(['category', 'primaryImage'])
            ->when(!empty($filters['search']), fn($q) => $q->where('name', 'like', '%'.$filters['search'].'%'))
            ->when(!empty($filters['category_id']), fn($q) => $q->where('category_id', $filters['category_id']))
            ->when(isset($filters['is_available']), fn($q) => $q->where('is_available', $filters['is_available']))
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }

    public function create(array $data, array $images = []): Product
    {
        return DB::transaction(function () use ($data, $images) {
            $data['slug'] = Str::slug($data['name']);
            $product = Product::create($data);
            $this->syncImages($product, $images);
            return $product;
        });
    }

    public function update(Product $product, array $data, array $images = []): Product
    {
        return DB::transaction(function () use ($product, $data, $images) {
            $data['slug'] = Str::slug($data['name']);
            $product->update($data);
            if (!empty($images)) {
                $this->syncImages($product, $images);
            }
            return $product;
        });
    }

    public function delete(Product $product): void
    {
        DB::transaction(function () use ($product) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            $product->images()->delete();
            $product->delete();
        });
    }

    public function setPrimaryImage(Product $product, int $imageId): void
    {
        $product->images()->update(['is_primary' => false]);
        $product->images()->where('id', $imageId)->update(['is_primary' => true]);
    }

    public function deleteImage(ProductImage $image): void
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
    }

    private function syncImages(Product $product, array $images): void
    {
        $isFirst = $product->images()->count() === 0;
        foreach ($images as $i => $file) {
            $path = $file->store('products', 'public');
            $product->images()->create([
                'image_path' => $path,
                'is_primary' => $isFirst && $i === 0,
                'is_active'  => true,
            ]);
        }
    }
}
