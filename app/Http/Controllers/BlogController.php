<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('admin')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        return view('store.blog', compact('posts'));
    }

    public function show(Post $post)
    {
        abort_if($post->status !== 'published', 404);

        $related = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)->get();

        return view('store.blog-detail', compact('post', 'related'));
    }
}
