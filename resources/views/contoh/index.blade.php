{{-- @extends('templates.template')
@section('title', 'Contoh View')
@section('content')
    @push('scripts')
        <script>
            console.log('Contoh view loaded');
        </script>
    @endpush
    <div class="container mt-5">
        <img src="{{ asset('images/example.jpeg') }}" alt="Example Image">
        <h1>Contoh View</h1>
        <p>This is a contoh view of the ecommerce-8 application.</p>
        <h5>Categories</h5>
        <ul>
            @foreach($categories as $category)
                <li>{{ $category['name'] }}</li>
            @endforeach
        </ul>
        @push('styles')
            <style>
                ul {
                    list-style-type: square;
                }
            </style>
        @endpush
        <h5>Products</h5>
        @foreach($products as $product)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text">Price: ${{ $product['price'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
    @push('styles')
        <style>
            .card {
                border: 1px solid #ccc;
                border-radius: 5px;
            }
        </style>
    @endpush
@endsection --}}

<x-template-layout title="Contoh View">
    <x-alert type="success">
        This is a success alert from the contoh view!
    </x-alert>
    <x-alert type="danger">
        This is a danger alert from the contoh view!
    </x-alert>
    <x-alert type="warning">
        This is a warning alert from the contoh view!
    </x-alert>
    @push('scripts')
        <script>
            console.log('Contoh view loaded');
        </script>
    @endpush
    <div class="container mt-5">
        <img src="{{ asset('images/example.jpeg') }}" alt="Example Image">
        <h1>Contoh View</h1>
        <p>This is a contoh view of the ecommerce-8 application.</p>
        <h5>Categories</h5>
        <ul>
            @foreach($categories as $category)
                <li>{{ $category['name'] }}</li>
            @endforeach
        </ul>
        @push('styles')
            <style>
                ul {
                    list-style-type: square;
                }
            </style>
        @endpush
        <h5>Products</h5>
        @foreach($products as $product)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text">Price: ${{ $product['price'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
    @push('styles')
        <style>
            .card {
                border: 1px solid #ccc;
                border-radius: 5px;
            }
        </style>
    @endpush
</x-template-layout>