@extends('templates.template')

@section('title', $title)

@section('content')
<div class="container mt-4">
    
    <div id="promoCarousel" class="carousel slide mb-4 shadow-sm rounded-3 overflow-hidden" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="1"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active bg-primary text-white p-5 text-center" style="min-height: 220px; background: linear-gradient(135deg, #0d6efd, #0dcaf0);">
                <div class="py-4">
                    <span class="badge bg-danger mb-2">PROMO BULAN INI</span>
                    <h2 class="fw-bold">Diskon Kilat Hingga 70%!</h2>
                    <p class="mb-0">Dapatkan gratis ongkir ke seluruh Indonesia tanpa minimum belanja.</p>
                </div>
            </div>
            <div class="carousel-item bg-success text-white p-5 text-center" style="min-height: 220px; background: linear-gradient(135deg, #198754, #20c997);">
                <div class="py-4">
                    <span class="badge bg-warning text-dark mb-2">NEW ARRIVAL</span>
                    <h2 class="fw-bold">Koleksi Gadget & Fashion Terbaru</h2>
                    <p class="mb-0">Cicilan 0% menggunakan berbagai metode pembayaran instan.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="card border-0 shadow-sm p-3 mb-4 rounded-3">
        <h6 class="fw-bold text-secondary mb-3">Kategori Pilihan</h6>
        <div class="d-flex gap-4 overflow-auto pb-2 text-center scrollbar-hidden">
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->slug]) }}" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                    <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm mb-2 hover-scale" style="width: 55px; height: 55px; border: 1px solid #e0e0e0;">
                        <span class="fw-bold text-primary text-uppercase">{{ substr($category->name, 0, 2) }}</span>
                    </div>
                    <span class="small text-truncate d-block" style="font-size: 12px;">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-3 rounded-3 bg-white">
                <form action="{{ route('home') }}" method="GET" role="search" id="filterForm">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4 col-6">
                            <select name="category" id="category" class="form-select form-select-sm border-light-subtle py-2" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-6">
                            <select name="sort" id="sort" class="form-select form-select-sm border-light-subtle py-2" onchange="this.form.submit()">
                                <option value="">Urutkan Terpopuler</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Harga: Terendah ke Tinggi</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Harga: Tertinggi ke Rendah</option>
                                <option value="best_seller" {{ request('sort') == 'best_seller' ? 'selected' : '' }}>Paling Laris</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 d-grid md-d-block">
                            @if(request('category') || request('sort') || request('search'))
                                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-danger py-2">Hapus Semua Filter</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3 text-dark">Rekomendasi Untukmu</h5>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-2 g-md-3 mb-5">
        @forelse($products as $item)
            <div class="col d-flex">
                <div class="card border-0 shadow-sm w-100 product-card rounded-3 overflow-hidden position-relative bg-white d-flex flex-column" style="transition: transform 0.2s, box-shadow 0.2s;">
                    
                    <span class="position-absolute badge bg-danger m-2 top-0 start-0 z-1" style="font-size: 10px;">Grosir</span>

                    <a href="{{ route('detail-product', ['slug' => $item->slug]) }}" class="text-decoration-none">
                        <div class="ratio ratio-1x1 bg-light">
                            <img src="{{ asset('images/' . $item->image) }}" class="card-img-top object-fit-cover" alt="{{ $item->name }}" onerror="this.src='https://placehold.co/300x300?text=No+Image'">
                        </div>
                    </a>

                    <div class="p-2 flex-grow-1 d-flex flex-col justify-content-between">
                        <div>
                            <a href="{{ route('detail-product', ['slug' => $item->slug]) }}" class="text-decoration-none text-dark">
                                <p class="card-title text-start fw-normal mb-1 text-truncate-2" style="font-size: 13px; line-height: 1.3; height: 34px;">
                                    {{ $item->name }}
                                </p>
                            </a>
                            
                            <h6 class="fw-bold text-dark text-start mb-1" style="font-size: 15px;">
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </h6>
                        </div>

                        <div class="mt-2 pt-2 border-top border-light-subtle">
                            <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                <span class="text-truncate" style="max-width: 75px;">
                                    📍 {{ $item->category->name }}
                                </span>
                                <span class="text-nowrap text-warning">
                                    ⭐ 4.9 | <span class="text-muted">Terjual</span>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 w-100 text-center py-5">
                <div class="text-muted">
                    <p class="fs-6">Produk tidak ditemukan. Coba gunakan kata kunci lain.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center my-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
    /* Mengizinkan pemotongan teks judul menjadi maksimal 2 baris */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    
    /* Efek Hover Card Terangkat */
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        cursor: pointer;
    }

    /* Efek Hover Kategori Lingkaran */
    .hover-scale:hover {
        transform: scale(1.08);
        border-color: #0d6efd !important;
        transition: transform 0.2s ease-in-out;
    }

    /* Menyembunyikan scrollbar bawaan browser pada kategori geser */
    .scrollbar-hidden::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hidden {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
@endsection