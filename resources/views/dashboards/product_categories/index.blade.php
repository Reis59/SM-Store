<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Categories') }}
            </h2>
            <x-primary-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-category')"
            >{{ __('Add Category') }}</x-primary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                {{-- Success & Error Messages --}}
                @include('layouts.success_error_message')
                <div class="p-6 text-gray-900">
                    {{-- Filter and search form can be added here --}}
                    <div class="flex flex-wrap justify-between gap-2 mb-4">
                        {{-- filter sort by --}}
                        <form action="{{ route('dashboard.product-categories.index') }}" method="GET">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="sort" onchange="this.form.submit()" class="border rounded px-4 py-2">
                                <option value="">Sort by</option>
                                <option value="products_count_desc" {{ request('sort') == 'products_count_desc' ? 'selected' : '' }}>Products Count: High to Low</option>
                                <option value="products_count_asc" {{ request('sort') == 'products_count_asc' ? 'selected' : '' }}>Products Count: Low to High</option>
                                <option value="total_value_desc" {{ request('sort') == 'total_value_desc' ? 'selected' : '' }}>Total Value: High to Low</option>
                                <option value="total_value_asc" {{ request('sort') == 'total_value_asc' ? 'selected' : '' }}>Total Value: Low to High</option>
                                <option value="total_stock_desc" {{ request('sort') == 'total_stock_desc' ? 'selected' : '' }}>Total Stock: High to Low</option>
                                <option value="total_stock_asc" {{ request('sort') == 'total_stock_asc' ? 'selected' : '' }}>Total Stock: Low to High</option>
                            </select>
                        </form>
                        <div class="flex flex-wrap gap-2">
                            {{-- search form --}}
                            <form action="{{ route('dashboard.product-categories.index') }}" method="GET">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <input type="text" name="search" placeholder="Search categories..." class="border rounded px-4 py-2" value="{{ request('search') }}">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
                            </form>
                            {{-- reset search --}}
                            @if(request('search') || request('sort'))
                                <a href="{{ route('dashboard.product-categories.index') }}" class="text-white bg-gray-500 px-4 py-2 rounded">Reset</a>
                            @endif
                        </div>
                    </div>
                    {{-- table for displaying product categories --}}
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Slug</th>
                                <th class="px-4 py-2 border">Products Count</th>
                                <th class="px-4 py-2 border">Total Stock</th>
                                <th class="px-4 py-2 border">Total Value</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td class="px-4 py-2 border">{{ $category->id }}</td>
                                <td class="px-4 py-2 border">{{ $category->name }}</td>
                                <td class="px-4 py-2 border">{{ $category->slug }}</td>
                                <td class="px-4 py-2 border">{{ $category->products_count }}</td>
                                <td class="px-4 py-2 border">{{ $category->total_stock ?? 0 }}</td>
                                <td class="px-4 py-2 border">Rp{{ number_format($category->total_value, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 border">
                                    <div class="flex flex-wrap gap-2">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded cursor-pointer" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'edit-category{{ $category->id }}')">Edit</button>
                                        <form action="{{ route('dashboard.product-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete category with id {{ $category->id }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded cursor-pointer">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @push('scripts')
                            <!-- Edit Modal -->
                            <x-modal name="edit-category{{ $category->id }}" focusable>
                                <div class="p-6 flex justify-between items-center">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Edit Product Category') }}
                                    </h2>
                                    <button
                                        x-on:click="$dispatch('close')"
                                        class="bg-gray-500 text-white px-4 py-2 rounded"
                                    >X</button>
                                </div>
                                <hr>
                                <form method="post" action="{{ route('dashboard.product-categories.update', $category) }}" class="p-6">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <x-input-label for="nameEdit{{ $category->id }}" :value="__('Category Name')" />
                                        <x-text-input id="nameEdit{{ $category->id }}" class="block mt-1 w-full p-2" type="text" name="name" value="{{ $category->name }}" required autofocus />
                                    </div>
                                    <div class="mt-4">
                                        <x-primary-button>{{ __('Update Category') }}</x-primary-button>
                                    </div>
                                </form>
                            </x-modal>
                            @endpush
                            @endforeach
                            {{-- More rows can be added here --}}
                        </tbody>
                    </table>
                    {{-- Pagination links can be added here --}}
                    <div class="mt-4">
                        {{ $categories->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
    <x-modal name="add-category" focusable>
        <div class="p-6 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Add New Product Category') }}
            </h2>
            <button
                x-on:click="$dispatch('close')"
                class="bg-gray-500 text-white px-4 py-2 rounded"
            >X</button>
        </div>
        <hr>
        <form method="post" action="{{ route('dashboard.product-categories.store') }}" class="p-6" id="add-category-form"> @csrf
            <div>
                <x-input-label for="name" :value="__('Category Name')" />
                <x-text-input id="name" class="block mt-1 w-full p-2" type="text" name="name" required autofocus />
            </div>
            <div class="mt-4">
                <x-primary-button>{{ __('Add Category') }}</x-primary-button>
            </div>
        </form>
    </x-modal>
    <script>
        // input validation for add category form
        document.getElementById('add-category-form').addEventListener('submit', function(event) {
            const nameInput = document.getElementById('name');
            if (nameInput.value.trim() === '') {
                event.preventDefault();
                alert('Category name is required.');
            }

            if(nameInput.value.length > 100) {
                event.preventDefault();
                alert('Category name must be less than 100 characters.');
            }

            if(nameInput.value.length < 3) {
                event.preventDefault();
                alert('Category name must be at least 3 characters.');
            }
        });
    </script>
@endpush
</x-app-layout>
