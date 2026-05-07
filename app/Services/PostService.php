<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function getAll(array $filters = [])
    {
        return Post::with('admin')
            ->when(!empty($filters['search']), fn($q) => $q->where('title', 'like', '%'.$filters['search'].'%'))
            ->when(!empty($filters['status']), fn($q) => $q->where('status', $filters['status']))
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }

    public function create(array $data, $thumbnail = null): Post
    {
        $data['admin_id'] = Auth::guard('admin')->id();
        $data['slug']     = Str::slug($data['title']);

        if ($thumbnail) {
            $data['thumbnail'] = $thumbnail->store('posts', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return Post::create($data);
    }

    public function update(Post $post, array $data, $thumbnail = null): Post
    {
        $data['slug'] = Str::slug($data['title']);

        if ($thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
            $data['thumbnail'] = $thumbnail->store('posts', 'public');
        }

        if ($data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);
        return $post;
    }

    public function delete(Post $post): void
    {
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        $post->delete();
    }
}
