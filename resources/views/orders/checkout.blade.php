@extends('templates.template')

@section('title', 'Checkout')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1>Checkout</h1>
                <p>Lengkapi data pengiriman dan tinjau pesanan Anda sebelum melanjutkan.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Informasi Pengiriman</h2>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('order.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="4" required>{{ old('address', $user->address) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Ringkasan Pesanan</h2>
                        <div class="list-group">
                            @foreach($cart_items as $item)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $item->product->name }}</strong>
                                            <div class="text-muted">Jumlah: {{ $item->quantity }}</div>
                                        </div>
                                        <div>Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 border-top pt-3">
                            <div class="d-flex justify-content-between">
                                <span>Total</span>
                                <strong>Rp{{ number_format($cart_items->sum(fn($item) => $item->product->price * $item->quantity), 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
