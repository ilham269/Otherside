@if($paginator->hasPages())
<div class="d-flex align-items-center justify-content-between mt-3 px-1" style="font-size:.82rem;">
    <div style="color:#64748b;">
        Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
    </div>
    <div class="d-flex gap-1">
        @if($paginator->onFirstPage())
            <span class="page-btn disabled"><i class="fa-solid fa-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
        @endif

        @foreach($paginator->getUrlRange(max(1, $paginator->currentPage()-2), min($paginator->lastPage(), $paginator->currentPage()+2)) as $page => $url)
            <a href="{{ $url }}" class="page-btn {{ $page == $paginator->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
        @else
            <span class="page-btn disabled"><i class="fa-solid fa-chevron-right"></i></span>
        @endif
    </div>
</div>
<style>
.page-btn {
    width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;
    text-decoration:none;color:#475569;border:1px solid #e2e8f0;font-size:.8rem;transition:all .15s;
}
.page-btn:hover:not(.disabled):not(.active){background:#f1f5f9;}
.page-btn.active{background:#6366f1;color:#fff;border-color:#6366f1;}
.page-btn.disabled{color:#cbd5e1;cursor:default;}
</style>
@endif
