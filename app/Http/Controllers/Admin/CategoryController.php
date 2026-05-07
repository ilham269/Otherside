<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service) {}

    public function index(\Illuminate\Http\Request $request)
    {
        $categories = $this->service->getAll($request->only('search', 'is_active'));
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = $this->service->getParents();
        return view('admin.categories.form', compact('parents'));
    }

    public function store(CategoryRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $parents = $this->service->getParents();
        return view('admin.categories.form', compact('category', 'parents'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->service->update($category, $request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(Category $category)
    {
        $this->service->delete($category);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
