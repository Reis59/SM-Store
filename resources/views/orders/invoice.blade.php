@extends('templates.template')

@section('title', 'Invoice Pesanan')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1>Invoice Pesanan</h1>
                <p>Pesanan Anda telah berhasil dibuat. Simpan nomor pesanan untuk referensi.</p>
                <div class="card mt-4">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Detail Pesanan</h2>
                        <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
                        <p><strong>Nama:</strong> {{ $order->name }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Telepon:</strong> {{ $order->phone }}</p>
                        <p><strong>Alamat:</strong> {{ $order->address }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Total:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>

                        <h3 class="h6 mt-4">Produk</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
