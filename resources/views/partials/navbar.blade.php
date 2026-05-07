<nav class="site-nav">
    <a href="{{ route('home') }}" class="nav-logo">
        <img src="{{ asset('img/logo-otherside.png') }}" alt="Otherside Logo">
    </a>

    <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products*') ? 'active' : '' }}">Product</a></li>
        <li><a href="{{ route('custom-order.index') }}" class="{{ request()->routeIs('custom-order*') ? 'active' : '' }}">Custom Order</a></li>
        <li><a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">Blog</a></li>
        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a></li>
    </ul>

    <div class="nav-actions">
        @auth
            <a href="{{ route('orders.index') }}" class="btn-nav outline">
                <i class="fa-solid fa-bag-shopping" style="font-size:.75rem;"></i> Pesanan
            </a>
            <a href="/home" class="btn-nav solid">My Account</a>
        @else
            <a href="{{ route('login') }}" class="btn-nav outline">Login</a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav solid">Register</a>
            @endif
        @endauth
    </div>
</nav>
