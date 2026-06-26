@extends('templates.template')

@section('title', 'Welcome to eCommerce-8')

@section('content')
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-dark text-white rounded-4 shadow">
        <div class="col-md-6 p-lg-5 mx-auto my-5">
            <span class="badge bg-primary px-3 py-2 rounded-pill uppercase tracking-wider mb-3">New Experience</span>
            <h1 class="display-3 fw-bold">Selamat Datang di eCommerce-8</h1>
            <p class="lead fw-normal text-muted-light my-4">Platform belanja online modern tercepat, termudah, dan terpercaya untuk memenuhi segala kebutuhan harian Anda.</p>
            <div class="d-flex gap-3 justify-content-center">
                <a class="btn btn-primary btn-lg px-4 rounded-pill fw-semibold" href="{{ route('home') }}">Mulai Belanja</a>
                <a class="btn btn-outline-light btn-lg px-4 rounded-pill" href="#">Pelajari Selengkapnya</a>
            </div>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

    <div class="container px-4 py-5" id="featured-3">
        <h2 class="pb-2 border-bottom fw-bold text-center mb-5">Kenapa Memilih Kami?</h2>
        <div class="row g-4 py-3 row-cols-1 row-cols-lg-3">
            <div class="feature col text-center">
                <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary text-white fs-2 mb-3 rounded-3 px-3 py-2">
                    📦
                </div>
                <h3 class="fs-4 fw-semibold text-body-emphasis">Kualitas Premium</h3>
                <p class="text-muted">Semua produk kami telah melewati proses seleksi kualitas yang ketat sebelum dikirim ke pelanggan.</p>
            </div>
            <div class="feature col text-center">
                <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary text-white fs-2 mb-3 rounded-3 px-3 py-2">
                    ⚡
                </div>
                <h3 class="fs-4 fw-semibold text-body-emphasis">Pengiriman Cepat</h3>
                <p class="text-muted">Bekerja sama dengan ekspedisi andalan untuk menjamin paket sampai di tangan Anda dengan kilat dan aman.</p>
            </div>
            <div class="feature col text-center">
                <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary text-white fs-2 mb-3 rounded-3 px-3 py-2">
                    🔒
                </div>
                <h3 class="fs-4 fw-semibold text-body-emphasis">Pembayaran Aman</h3>
                <p class="text-muted">Sistem transaksi enkripsi mutakhir yang menjaga keamanan data pembayaran Anda tanpa rasa khawatir.</p>
            </div>
        </div>
    </div>
@endsection