@if(isset($ui) && $ui === 'bootstrap')
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center justify-content-between">
            <div>{{ session('success') }}</div>
            @if(isset($cart) && $cart === true)
                <a href="{{ route('cart') }}" class="btn btn-primary">Lihat Keranjang</a>
            @endif
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @elseif(session('errors'))
        <div class="alert alert-danger">
            <ul>
                @foreach(session('errors')->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@else
@if(session('success'))
    <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
        {{ session('success') }}
    </div>
@endif
    @if($errors->any())
        <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endif