<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Product') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @include('layouts.success_error_message')
                <form action="{{ route('dashboard.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 text-gray-900" id="product-form">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" step="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="product_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="product_category_id" id="product_category_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 flex flex-wrap justify-between gap-2">
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" accept="image/*">
                            {{-- <img src="" id="image-preview" class="hidden mt-2 max-h-48"> --}}
                            <div id="cropperContainer" style="display: none; margin-top: 20px;">
                                <div id="image-preview"></div>
                            </div>
                            <input type="hidden" name="cropped_image" id="cropped_image">
                            <div>
                                <p class="text-xs text-gray-500 mt-1">Allowed file types: jpg, jpeg, png. Max size: 2MB.</p>
                                <p class="text-xs text-gray-500">Recommended dimensions: 800x800 pixels.</p>
                            </div>
                        </div>
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="mt-1 block max-h-48">
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('dashboard.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</a>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@include('dashboards.products.validation_script_v2')
</x-app-layout>