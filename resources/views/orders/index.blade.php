@extends('templates.template')

@section('title', 'Daftar Transaksi Saya')

@section('content')
<div class="container mt-4 mb-5">
    <div class="row g-4">
        

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">Daftar Transaksi</h4>
                <span class="text-muted small">Menampilkan semua riwayat belanja Anda</span>
            </div>

            {{-- Kondisi jika data transaksi masih kosong atau belum ada variabel $orders --}}
            @if(!isset($orders) || $orders->isEmpty())
                <div class="text-center py-5 card border-0 shadow-sm bg-white rounded-3">
                    <div class="py-4">
                        <span style="font-size: 64px;">📦</span>
                        <h5 class="fw-bold mt-3 mb-1">Belum ada transaksi</h5>
                        <p class="text-muted small">Kamu belum pernah berbelanja di eCommerce-8. Yuk cari barang impianmu!</p>
                        <a href="{{ route('home') }}" class="btn btn-success px-4 rounded-pill fw-semibold mt-2">Mulai Belanja</a>
                    </div>
                </div>
            @else
                
                @foreach($orders as $order)
                    <div class="card border-0 shadow-sm bg-white rounded-3 mb-4 p-3 hover-shadow-card">
                        
                        <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-2 mb-3 gap-2">
                            <div class="d-flex align-items-center flex-wrap gap-2 small">
                                <span class="fw-bold text-dark">🛍️ Belanja</span>
                                <span class="text-muted">{{ $order->created_at->format('d M Y') }}</span>
                                <span class="badge bg-light text-secondary border border-light-subtle">INV/{{ $order->id }}/{{ $order->created_at->format('Ymd') }}</span>
                            </div>
                            
                            <div>
                                @if(in_array($order->status, ['completed', 'success', 'selesai']))
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 11px;">Selesai</span>
                                @elseif(in_array($order->status, ['pending', 'unpaid']))
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 11px;">Menunggu Pembayaran</span>
                                @elseif(in_array($order->status, ['processing', 'shipping', 'dikirim']))
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 11px;">Diproses</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 11px;">Batal</span>
                                @endif
                            </div>
                        </div>

                        @if($order->orderItems && $order->orderItems->first())
                            @php $firstItem = $order->orderItems->first(); @endphp
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="bg-light rounded overflow-hidden shadow-sm flex-shrink-0" style="width: 70px; height: 70px;">
                                        <img src="{{ asset('images/' . $firstItem->product->image) }}" alt="{{ $firstItem->product->name }}" class="w-100 h-100 object-fit-cover" onerror="this.src='https://placehold.co/100x100?text=Produk'">
                                    </div>
                                    
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">{{ $firstItem->product->name }}</h6>
                                        <p class="text-muted mb-0 small">
                                            {{ $firstItem->quantity }} barang x Rp{{ number_format($firstItem->price ?? $firstItem->product->price, 0, ',', '.') }}
                                        </p>
                                        
                                        @if($order->orderItems->count() > 1)
                                            <p class="text-muted small mt-1 mb-0" style="font-size: 12px;">
                                                +{{ $order->orderItems->count() - 1 }} produk lainnya
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex flex-row flex-md-column justify-content-between align-items-end text-end border-top pt-2 pt-md-0 border-md-top-0 gap-2 flex-shrink-0">
                                    <div class="w-100-mobile text-start text-md-end">
                                        <span class="text-muted small d-block">Total Belanja</span>
                                        <span class="fw-bold text-dark fs-6">
                                            Rp{{ number_format($order->total_price ?? $order->orderItems->sum(function($item){ return $item->price * $item->quantity; }), 0, ',', '.') }}
                                        </span>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('order.invoice', ['order_number' => $order->order_number ?? $order->id]) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold" style="font-size: 12px;">
                                            Lihat Detail
                                        </a>
                                        @if(in_array($order->status, ['completed', 'success', 'selesai']))
                                            <a href="{{ route('home') }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold" style="font-size: 12px;">
                                                Beli Lagi
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @endif

                    </div>
                @endforeach

            @endif
        </div>

    </div>
</div>

<style>
    .hover-shadow-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-shadow-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important;
    }
    @media (max-width: 767.98px) {
        .w-100-mobile {
            width: 100%;
        }
    }
</style>
@endsection