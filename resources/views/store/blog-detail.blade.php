@extends('layouts.store')
@section('title', $post->title . ' — Otherside Blog')

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Breadcrumb --}}
            <div style="font-size:.78rem;color:#999;margin-bottom:1.5rem;">
                <a href="{{ route('home') }}" style="color:#999;text-decoration:none;">Home</a>
                <span class="mx-1">›</span>
                <a href="{{ route('blog.index') }}" style="color:#999;text-decoration:none;">Blog</a>
                <span class="mx-1">›</span>
                <span style="color:#333;">{{ Str::limit($post->title, 40) }}</span>
            </div>

            {{-- Tags --}}
            @if($post->tags)
            <div style="margin-bottom:.75rem;">
                @foreach(explode(',', $post->tags) as $tag)
                <span style="font-size:.68rem;font-weight:800;background:#f4f4f4;color:#666;padding:3px 10px;border-radius:20px;margin-right:.3rem;text-transform:uppercase;letter-spacing:.5px;">
                    {{ trim($tag) }}
                </span>
                @endforeach
            </div>
            @endif

            <h1 style="font-weight:900;font-size:1.75rem;line-height:1.25;margin-bottom:.75rem;">{{ $post->title }}</h1>

            <div style="font-size:.8rem;color:#999;margin-bottom:1.5rem;">
                <i class="fa-regular fa-calendar me-1"></i> {{ $post->published_at?->format('d M Y') }}
                <span class="mx-2">·</span>
                <i class="fa-regular fa-user me-1"></i> {{ $post->admin->name ?? 'Admin' }}
            </div>

            {{-- Thumbnail --}}
            @if($post->thumbnail)
            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                style="width:100%;border-radius:16px;margin-bottom:2rem;display:block;">
            @endif

            {{-- Body --}}
            <div style="font-size:.92rem;color:#333;line-height:1.85;">
                {!! $post->body !!}
            </div>

            {{-- Share --}}
            <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid #f0f0f0;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
                <span style="font-size:.8rem;font-weight:700;color:#999;">Bagikan:</span>
                @foreach(['whatsapp'=>'fa-whatsapp','twitter'=>'fa-x-twitter','facebook'=>'fa-facebook-f'] as $name => $icon)
                <a href="#" style="width:34px;height:34px;border-radius:50%;border:1px solid #e0e0e0;display:inline-flex;align-items:center;justify-content:center;color:#666;font-size:.8rem;text-decoration:none;transition:all .2s;"
                    onmouseover="this.style.background='#0a0a0a';this.style.color='#fff';this.style.borderColor='#0a0a0a'"
                    onmouseout="this.style.background='';this.style.color='#666';this.style.borderColor='#e0e0e0'">
                    <i class="fa-brands {{ $icon }}"></i>
                </a>
                @endforeach
            </div>

        </div>
    </div>

    {{-- Related Posts --}}
    @if($related->count())
    <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid #f0f0f0;">
        <div class="section-label">Artikel Lainnya</div>
        <div class="row g-3">
            @foreach($related as $rel)
            <div class="col-md-4">
                <a href="{{ route('blog.show', $rel) }}" style="text-decoration:none;">
                    <div style="background:#fff;border:1px solid #ebebeb;border-radius:14px;overflow:hidden;transition:box-shadow .2s;"
                        onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,.08)'"
                        onmouseout="this.style.boxShadow=''">
                        @if($rel->thumbnail)
                            <img src="{{ Storage::url($rel->thumbnail) }}" style="width:100%;height:140px;object-fit:cover;display:block;">
                        @else
                            <div style="width:100%;height:140px;background:#f4f4f4;display:flex;align-items:center;justify-content:center;color:#ddd;font-size:2rem;">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                        @endif
                        <div style="padding:.9rem 1rem;">
                            <div style="font-weight:700;font-size:.85rem;color:#0a0a0a;line-height:1.35;">{{ $rel->title }}</div>
                            <div style="font-size:.75rem;color:#aaa;margin-top:.3rem;">{{ $rel->published_at?->format('d M Y') }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
