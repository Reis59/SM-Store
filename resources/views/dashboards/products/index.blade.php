<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('dashboard.products.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Add Product</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @include('layouts.success_error_message')
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap justify-between gap-2 mb-4">
                        {{-- Sort by filter --}}
                        <form action="{{ route('dashboard.products.index') }}" method="GET">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="sort" onchange="this.form.submit()" class="border rounded px-4 py-2">
                                <option value="">Sort by</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="best_seller" {{ request('sort') == 'best_seller' ? 'selected' : '' }}>Best Seller</option>
                                <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stock: Low to High</option>
                                <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Stock: High to Low</option>
                            </select>
                        </form>
                        <div class="flex flex-wrap gap-2">
                            {{-- search form --}}
                            <form action="{{ route('dashboard.products.index') }}" method="GET">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <input type="text" name="search" placeholder="Search products..." class="border rounded px-4 py-2" value="{{ request('search') }}">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
                            </form>
                            {{-- reset search --}}
                            @if(request('search') || request('sort'))
                                <a href="{{ route('dashboard.products.index') }}" class="text-white bg-gray-500 px-4 py-2 rounded">Reset</a>
                            @endif
                        </div>
                    </div>
                    {{-- Products table will go here --}}
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Description</th>
                                <th class="px-4 py-2 border">Price</th>
                                <th class="px-4 py-2 border">Stock</th>
                                <th class="px-4 py-2 border">Category</th>
                                <th class="px-4 py-2 border">Image</th>
                                <th class="px-4 py-2 border">Sold</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="px-4 py-2 border">{{ $product->id }}</td>
                                <td class="px-4 py-2 border">{{ $product->name }}</td>
                                <td class="px-4 py-2 border">{{ $product->description }}</td>
                                <td class="px-4 py-2 border">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 border">{{ $product->stock }}</td>
                                <td class="px-4 py-2 border">{{ $product->category->name }}</td>
                                <td class="px-4 py-2 border">
                                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-16">
                                </td>
                                <td class="px-4 py-2 border">{{ $product->order_items_count }}</td>
                                <td class="px-4 py-2 border">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('dashboard.products.edit', $product) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded cursor-pointer">Edit</a>
                                        <form action="{{ route('dashboard.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete product with id {{ $product->id }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded cursor-pointer">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
