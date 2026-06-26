<div class="card" style="width: 14rem;">
  <img src="{{ $image }}" class="card-img-top" alt="{{ $title }}">
  <div class="card-body">
    {{-- category name --}}
    <p class="card-text text-muted mb-1">{{ $category ?? 'Uncategorized' }}</p>
    <h5 class="card-title text-clamp-1">{{ $title }}</h5>
    <p class="card-text text-clamp-2">{{ $description }}</p>
    <p class="card-text fw-bold">Rp {{ number_format($price, 0, ',', '.') }}</p>
    <a href="{{ $link }}" class="btn btn-primary">Lihat Detail</a>
  </div>
</div>