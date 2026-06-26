@extends('templates.template')

@section('title', $product->name)

@section('content')
    <div class="container mt-5">
        <div class="row">
            @include('layouts.success_error_message', ['ui' => 'bootstrap', 'cart'=>true])
            <div class="col-md-6">
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid w-100 mb-3 rounded">
            </div>
            <div class="col-md-6">
                <h6>{{ $product->category->name }}</h6>
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <p class="h4 text-primary">Price: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p>Stock: {{ $product->stock }}</p>
                <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="GET"  class="d-flex align-items-center gap-3 mt-4">
                    {{-- quantity input can be added here --}}
                    <div class="input-group" style="width: 120px;">
                        <button class="btn btn-outline-secondary" type="button" id="button-decrease">-</button>
                        <input type="text" class="form-control text-center" max="{{ $product->stock }}" name="quantity" value="1" id="quantity-input">
                        <button class="btn btn-outline-secondary" type="button" id="button-increase">+</button>
                    </div>
                    <button type="submit" class="btn  {{ $product->stock <= 0 ? 'btn-secondary' : 'btn-primary' }}" {!! $product->stock <= 0 ? 'onclick="alert(\'Stock tidak tersedia\')"' : '' !!}>Tambahkan ke Keranjang</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <h3>Related Products</h3>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($related_products as $related)
                        <x-product-card 
                            title="{{ $related->name }}" 
                            description="{{ $related->description }}" 
                            image="{{ asset('images/' . $related->image) }}" 
                            link="{{ route('detail-product', ['slug' => $related->slug]) }}"
                            category="{{ $related->category->name }}"
                            price="{{ $related->price }}"
                        />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
<script>
    document.getElementById('button-decrease').addEventListener('click', function() {
        var quantityInput = document.getElementById('quantity-input');
        var currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    document.getElementById('button-increase').addEventListener('click', function() {
        var quantityInput = document.getElementById('quantity-input');
        var currentValue = parseInt(quantityInput.value);
        var maxValue = parseInt(quantityInput.getAttribute('max'));
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
        }
    });
</script>
@endsection