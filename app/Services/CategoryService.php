<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function getAll(array $filters = [])
    {
        return Category::with('parent')
            ->when(!empty($filters['search']), fn($q) => $q->where('name', 'like', '%'.$filters['search'].'%'))
            ->when(isset($filters['is_active']), fn($q) => $q->where('is_active', $filters['is_active']))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();
    }

    public function getParents()
    {
        return Category::whereNull('parent_id')->where('is_active', true)->orderBy('name')->get();
    }

    public function create(array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        // Reassign children to parent's parent
        $category->children()->update(['parent_id' => $category->parent_id]);
        $category->delete();
    }
}
