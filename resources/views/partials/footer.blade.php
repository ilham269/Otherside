<footer class="site-footer" id="about">
    <div class="page-wrap">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="footer-brand">Otherside</div>
                <div class="footer-tagline">Official Store</div>
                <p style="font-size:.8rem;color:rgba(255,255,255,.35);margin-top:.75rem;line-height:1.65;">
                    Produk custom berkualitas tinggi untuk gaya hidupmu.
                </p>
            </div>
            <div class="col-6 col-md-2">
                <div class="footer-section-title">Shop</div>
                <ul class="footer-links">
                    <li><a href="#products">Products</a></li>
                    <li><a href="#categories">Categories</a></li>
                    <li><a href="#">Custom Order</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-2">
                <div class="footer-section-title">Info</div>
                <ul class="footer-links">
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="footer-section-title">Follow Us</div>
                <div class="d-flex gap-2">
                    @foreach(['instagram' => 'fa-instagram', 'tiktok' => 'fa-tiktok', 'twitter' => 'fa-x-twitter', 'whatsapp' => 'fa-whatsapp'] as $name => $icon)
                    <a href="#" class="social-btn" title="{{ ucfirst($name) }}">
                        <i class="fa-brands {{ $icon }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} Otherside Official Store. All rights reserved.</span>
            <span>Made with ❤️</span>
        </div>
    </div>
</footer>
