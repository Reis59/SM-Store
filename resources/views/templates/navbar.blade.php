<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom py-3 shadow-sm">
    <div class="container gap-2 gap-md-4">
        
        <a class="navbar-brand fw-bold text-success fs-4 tracking-tight" href="{{ route('home') }}" style="letter-spacing: -1px;">
            SM<span class="text-warning">-Store</span>
        </a>

        <div class="flex-grow-1 mx-2 mx-md-4 order-3 order-lg-2 w-100-mobile">
            <form action="{{ route('home') }}" method="GET" class="position-relative">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                
                <div class="input-group">
                    <input type="text" name="search" class="form-control border-end-0 py-2 ps-3 rounded-start-pill border-light-subtle bg-light-subtle" placeholder="Cari barang atau kategori favoritmu..." value="{{ request('search') }}" style="font-size: 14px;">
                    <button class="btn btn-success border-start-0 px-4 rounded-end-pill" type="submit">
                        🔍
                    </button>
                </div>
            </form>
        </div>

        <div class="d-flex align-items-center gap-3 order-2 order-lg-3 ms-auto">
            
            <a href="{{ route('cart.index') }}" class="position-relative text-dark px-2 hover-opacity text-decoration-none">
                🛒
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px; padding: 3px 6px;">
                    @auth
                        {{ \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity') }}
                    @else
                        0
                    @endauth
                </span>
            </a>

            <div class="vr d-none d-md-block text-black-50" style="height: 24px;"></div>

            <div class="d-flex gap-2 align-items-center">
                @if (Route::has('login'))
                    @auth
                        <div class="dropdown">
                            <a class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-pill px-3 d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                👤 <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                            @auth
                                @if(auth()->user()->role === 'admin')
                                <li><a class="dropdown-item px-3 py-2 small" href="{{ route('dashboard') }}">Dashboard Admin</a></li>
                                @endif
                            @endauth
                                <li><a class="dropdown-item px-3 py-2 small" href="{{ route('order.list') }}">Transaksi Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item px-3 py-2 text-danger bg-transparent border-0 w-100 text-start small">
                                            Keluar Akun
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-success px-3 rounded-pill fw-semibold" style="font-size: 13px;">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-sm btn-success px-3 rounded-pill fw-semibold d-none d-md-inline-block" style="font-size: 13px;">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>

        </div>

    </div>
</nav>

<style>
    @media (max-width: 991.98px) {
        .w-100-mobile {
            width: 100% !important;
            order: 4 !important;
            margin-top: 10px;
        }
    }
    .hover-opacity:hover {
        opacity: 0.7;
        transition: opacity 0.15s ease-in-out;
    }
</style>