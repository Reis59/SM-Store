@extends('templates.template')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mt-4 mb-5">
    
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    ✨ {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    ⚠️ {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session('errors'))
                <div class="alert alert-danger border-0 shadow-sm">
                    <ul class="mb-0">
                        @foreach(session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <h4 class="fw-bold text-dark mb-4">Keranjang</h4>

    @if($cart_items->isEmpty() && $cart_items_sold->isEmpty())
        <div class="text-center py-5 card border-0 shadow-sm bg-white rounded-3">
            <div class="py-4">
                <span style="font-size: 64px;">🛒</span>
                <h5 class="fw-bold mt-3 mb-1">Wah, keranjang belanjamu kosong</h5>
                <p class="text-muted small">Yuk, isi dengan barang-barang impianmu sekarang!</p>
                <a href="{{ route('home') }}" class="btn btn-success px-4 rounded-pill fw-semibold mt-2">Mulai Belanja</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            
            <div class="col-lg-8">
                
                @if(!$cart_items->isEmpty())
                    <div class="card border-0 shadow-sm bg-white p-3 rounded-3 mb-4">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                            <span class="fw-bold text-dark fs-6">Daftar Produk</span>
                            <span class="text-muted small">{{ $cart_items->count() }} Produk</span>
                        </div>

                        @foreach($cart_items as $item)
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 pb-3 mb-3 border-bottom align-items-md-center">
                                
                                <div class="d-flex gap-3 align-items-center flex-grow-1">
                                    <div class="bg-light rounded overflow-hidden shadow-sm flex-shrink-0" style="width: 80px; height: 80px;">
                                        <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-100 h-100 object-fit-cover" onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                    </div>
                                    <div class="text-truncate-container" style="max-width: 320px;">
                                        <h6 class="fw-semibold text-dark mb-1 text-truncate" style="font-size: 14px;">{{ $item->product->name }}</h6>
                                        <span class="badge bg-light text-secondary border border-light-subtle mb-1" style="font-size: 11px;">📍 {{ $item->product->category->name ?? 'Kategori' }}</span>
                                        <div class="fw-bold text-success" style="font-size: 15px;">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between justify-content-md-end gap-3 flex-shrink-0">
                                    
                                    <form action="{{ route('cart.update', ['id' => $item->id]) }}" method="POST" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <div class="input-group input-group-sm rounded-pill overflow-hidden border border-secondary-subtle" style="width: 110px;">
                                            <button class="btn btn-link text-decoration-none text-dark bg-light border-0" type="button" onclick="decreaseQuantity({{ $item->id }})"><b>-</b></button>
                                            <input type="text" class="form-control text-center border-0 bg-white fw-semibold px-0" max="{{ $item->product->stock }}" name="quantity" value="{{ $item->quantity }}" id="quantity-input-{{ $item->id }}" readonly style="font-size: 13px;">
                                            <button class="btn btn-link text-decoration-none text-dark bg-light border-0" type="button" onclick="increaseQuantity({{ $item->id }})"><b>+</b></button>
                                        </div>
                                    </form>

                                    <form action="{{ route('cart.remove', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-1 hover-scale-btn text-decoration-none" title="Hapus dari keranjang">
                                            🗑️
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!$cart_items_sold->isEmpty())
                    <div class="card border-0 shadow-sm bg-white p-3 rounded-3 opacity-75">
                        <h6 class="fw-bold text-secondary mb-3">Tidak Bisa Dibeli (Stok Habis)</h6>
                        
                        @foreach($cart_items_sold as $item)
                            <div class="d-flex justify-content-between gap-3 pb-3 mb-3 border-bottom align-items-center">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="bg-light rounded overflow-hidden flex-shrink-0" style="width: 70px; height: 70px; filter: grayscale(100%);">
                                        <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-100 h-100 object-fit-cover" onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1 small text-decoration-line-through">{{ $item->product->name }}</h6>
                                        <div class="text-muted small">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                
                                <form action="{{ route('cart.remove', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-size: 11px;">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-white p-4 rounded-3 position-sticky" style="top: 100px;">
                    <h6 class="fw-bold text-dark mb-3">Ringkasan Belanja</h6>
                    
                    <div class="d-flex justify-content-between mb-2 text-muted small">
                        <span>Total Barang (Aman)</span>
                        <span>
                            {{ $cart_items->sum('quantity') }} Item
                        </span>
                    </div>
                    
                    <hr class="border-light-subtle my-3">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark fs-6">Total Harga</span>
                        <span class="fw-bold text-success fs-5">
                            Rp{{ number_format($cart_items->sum(function($item) { return $item->product->price * $item->quantity; }), 0, ',', '.') }}
                        </span>
                    </div>

                    @if(Route::has('checkout'))
                        <a href="{{ route('checkout') }}" class="btn btn-success w-100 py-2.5 rounded-pill fw-bold {{ $cart_items->isEmpty() ? 'disabled' : '' }}" style="font-size: 15px; letter-spacing: 0.5px;">
                            Beli ({{ $cart_items->sum('quantity') }})
                        </a>
                    @else
                        <a href="#" class="btn btn-success w-100 py-2.5 rounded-pill fw-bold {{ $cart_items->isEmpty() ? 'disabled' : '' }}" style="font-size: 15px; letter-spacing: 0.5px;">
                            Beli ({{ $cart_items->sum('quantity') }})
                        </a>
                    @endif
                </div>
            </div>

        </div>
    @endif
</div>

@push('scripts')
<script>
    function decreaseQuantity(id) {
        const input = document.getElementById(`quantity-input-${id}`);
        let currentValue = parseInt(input.value);
        if(currentValue > 1){
            input.value = currentValue - 1;
        }
    }

    function increaseQuantity(id) {
        const input = document.getElementById(`quantity-input-${id}`);
        let currentValue = parseInt(input.value);
        const maxValue = parseInt(input.getAttribute('max'));
        if(currentValue < maxValue){
            input.value = currentValue + 1;
        }
    }
</script>
@endpush

<style>
    /* Efek hover interaktif */
    .hover-scale-btn:hover {
        transform: scale(1.15);
        transition: transform 0.15s ease-in-out;
    }
</style>
@endsection