<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $service) {}

    public function index(Request $request)
    {
        $posts = $this->service->getAll($request->only('search', 'status'));
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.form');
    }

    public function store(PostRequest $request)
    {
        $this->service->create($request->validated(), $request->file('thumbnail'));
        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->service->update($post, $request->validated(), $request->file('thumbnail'));
        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diupdate.');
    }

    public function destroy(Post $post)
    {
        $this->service->delete($post);
        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dihapus.');
    }
}
