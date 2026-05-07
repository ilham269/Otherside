@extends('layouts.store')
@section('title', 'Blog — Otherside Store')

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    <div style="margin-bottom:2rem;">
        <div style="font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:2px;color:#999;margin-bottom:.4rem;">Artikel & Tips</div>
        <h2 style="font-weight:900;font-size:1.75rem;margin:0;">Blog</h2>
    </div>

    @if($posts->count())
    <div class="row g-4">
        @foreach($posts as $post)
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('blog.show', $post) }}" style="text-decoration:none;display:block;height:100%;">
                <div style="background:#fff;border:1px solid #ebebeb;border-radius:16px;overflow:hidden;height:100%;transition:box-shadow .2s,transform .2s;"
                    onmouseover="this.style.boxShadow='0 8px 28px rgba(0,0,0,.09)';this.style.transform='translateY(-3px)'"
                    onmouseout="this.style.boxShadow='';this.style.transform=''">
                    {{-- Thumbnail --}}
                    @if($post->thumbnail)
                        <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                            style="width:100%;height:180px;object-fit:cover;display:block;">
                    @else
                        <div style="width:100%;height:180px;background:#f4f4f4;display:flex;align-items:center;justify-content:center;color:#ddd;font-size:2.5rem;">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                    @endif

                    <div style="padding:1.1rem 1.25rem 1.25rem;">
                        {{-- Tags --}}
                        @if($post->tags)
                        <div style="margin-bottom:.5rem;">
                            @foreach(array_slice(explode(',', $post->tags), 0, 2) as $tag)
                            <span style="font-size:.65rem;font-weight:800;background:#f4f4f4;color:#666;padding:2px 8px;border-radius:20px;margin-right:.25rem;text-transform:uppercase;letter-spacing:.5px;">
                                {{ trim($tag) }}
                            </span>
                            @endforeach
                        </div>
                        @endif

                        <div style="font-weight:800;font-size:.95rem;color:#0a0a0a;line-height:1.35;margin-bottom:.4rem;">
                            {{ $post->title }}
                        </div>
                        <div style="font-size:.78rem;color:#999;">
                            {{ $post->published_at?->format('d M Y') }} · {{ $post->admin->name ?? 'Admin' }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($posts->hasPages())
    <div class="d-flex justify-content-center mt-4 gap-2" style="font-size:.83rem;">
        @if($posts->onFirstPage())
            <span style="padding:.4rem .85rem;border:1px solid #e0e0e0;border-radius:8px;color:#ccc;">‹</span>
        @else
            <a href="{{ $posts->previousPageUrl() }}" style="padding:.4rem .85rem;border:1px solid #e0e0e0;border-radius:8px;color:#333;text-decoration:none;">‹</a>
        @endif
        @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
            <a href="{{ $url }}" style="padding:.4rem .85rem;border:1px solid {{ $page==$posts->currentPage()?'#0a0a0a':'#e0e0e0' }};border-radius:8px;background:{{ $page==$posts->currentPage()?'#0a0a0a':'#fff' }};color:{{ $page==$posts->currentPage()?'#fff':'#333' }};text-decoration:none;">{{ $page }}</a>
        @endforeach
        @if($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}" style="padding:.4rem .85rem;border:1px solid #e0e0e0;border-radius:8px;color:#333;text-decoration:none;">›</a>
        @else
            <span style="padding:.4rem .85rem;border:1px solid #e0e0e0;border-radius:8px;color:#ccc;">›</span>
        @endif
    </div>
    @endif

    @else
    <div style="text-align:center;padding:4rem 0;">
        <div style="font-size:3rem;color:#e0e0e0;margin-bottom:1rem;"><i class="fa-solid fa-newspaper"></i></div>
        <div style="font-weight:700;color:#333;">Belum ada artikel</div>
    </div>
    @endif

</div>
@endsection
