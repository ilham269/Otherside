<nav class="site-nav">
    <a href="{{ route('home') }}" class="nav-logo">
        <img src="{{ asset('img/logo-otherside.png') }}" alt="Otherside Logo">
    </a>

    <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#products">Product</a></li>
        <li><a href="#categories">Categories</a></li>
    </ul>

    <div class="nav-actions">
        @auth
            <a href="/home" class="btn-nav outline">My Account</a>
        @else
            <a href="{{ route('login') }}" class="btn-nav outline">Login</a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav solid">Register</a>
            @endif
        @endauth
    </div>
</nav>
