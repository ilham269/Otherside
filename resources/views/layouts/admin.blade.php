<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }} Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/sass/admin.scss', 'resources/js/admin.js'])
</head>
<body>

{{-- Sidebar Overlay (mobile) --}}
<div id="sidebarOverlay" class="d-none" style="position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;"></div>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-logo">
            <div class="brand-icon"><i class="fa-solid fa-store"></i></div>
            <div class="brand-name">Other<span>side</span></div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-title">Main</div>

        <div class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-gauge"></i></span>
                Dashboard
            </a>
        </div>

        <div class="nav-section-title mt-2">Catalog</div>

        <div class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-box"></i></span>
                Products
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-tags"></i></span>
                Categories
            </a>
        </div>

        <div class="nav-section-title mt-2">Orders</div>

        <div class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders*') && !request()->routeIs('admin.custom-orders*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                Orders
                @php $pendingOrders = \App\Models\Order::where('status','pending')->count() @endphp
                @if($pendingOrders > 0)
                    <span class="nav-badge">{{ $pendingOrders }}</span>
                @endif
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.custom-orders.index') }}" class="nav-link {{ request()->routeIs('admin.custom-orders*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-pen-ruler"></i></span>
                Custom Orders
                @php $pendingCustom = \App\Models\CustomOrder::where('status','pending')->count() @endphp
                @if($pendingCustom > 0)
                    <span class="nav-badge">{{ $pendingCustom }}</span>
                @endif
            </a>
        </div>

        <div class="nav-section-title mt-2">Content</div>

        <div class="nav-item">
            <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-newspaper"></i></span>
                Posts
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-message"></i></span>
                Messages
                @php $unread = \App\Models\Message::whereNull('read_at')->where('is_reply', false)->count() @endphp
                @if($unread > 0)
                    <span class="nav-badge">{{ $unread }}</span>
                @endif
            </a>
        </div>

        <div class="nav-section-title mt-2">Users</div>

        <div class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                Users
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <span class="nav-icon"><i class="fa-solid fa-user-shield"></i></span>
                Admins
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-profile dropdown">
            <div data-bs-toggle="dropdown" aria-expanded="false">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar">{{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}</div>
                    <div class="profile-info">
                        <div class="name">{{ Auth::guard('admin')->user()->name }}</div>
                        <div class="role">{{ ucfirst(Auth::guard('admin')->user()->role) }}</div>
                    </div>
                    <i class="fa-solid fa-ellipsis-vertical ms-auto" style="color:#64748b;font-size:.8rem;"></i>
                </div>
            </div>
            <ul class="dropdown-menu dropdown-menu-dark mb-2" style="min-width:180px;">
                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>

{{-- Main Wrapper --}}
<div class="main-wrapper">
    {{-- Topbar --}}
    <header class="topbar">
        <button id="sidebarToggle" class="btn-icon d-lg-none">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-actions">
            <button class="btn-icon" title="Notifications">
                <i class="fa-solid fa-bell"></i>
                <span class="badge-dot"></span>
            </button>
            <button class="btn-icon" title="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="page-content">
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>