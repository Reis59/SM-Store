<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @include('layouts.success_error_message')
                    <div class="flex flex-wrap justify-between gap-2 mb-4">
                        {{-- Sort by filter --}}
                        <form action="{{ route('dashboard.orders.index') }}" method="GET">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="sort" onchange="this.form.submit()" class="border rounded px-4 py-2">
                                <option value="">Sort by</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Order Date: Oldest to Newest</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Order Date: Newest to Oldest</option>
                            </select>
                        </form>
                        <form action="{{ route('dashboard.orders.index') }}" method="GET">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="status" onchange="this.form.submit()" class="border rounded px-4 py-2">
                                <option value="">Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                        <div class="flex flex-wrap gap-2">
                            {{-- search form --}}
                            <form action="{{ route('dashboard.orders.index') }}" method="GET">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <input type="text" name="search" placeholder="Search orders..." class="border rounded px-4 py-2" value="{{ request('search') }}">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
                            </form>
                            {{-- reset search --}}
                            @if(request('search') || request('sort'))
                                <a href="{{ route('dashboard.orders.index') }}" class="text-white bg-gray-500 px-4 py-2 rounded">Reset</a>
                            @endif
                        </div>
                    </div>
                    {{-- Orders table will go here --}}
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border">Order Number</th>
                                <th class="px-4 py-2 border">Customer Name</th>
                                <th class="px-4 py-2 border">Total Amount</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Order Date</th>
                                @if(Auth::user()->role === 'admin')
                                <th class="px-4 py-2 border">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="px-4 py-2 border">
                                    <a href="{{ route('order.invoice', ['order_number' => $order->order_number]) }}" class="text-blue-500 hover:underline">
                                    {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border">{{ $order->name }}</td>
                                <td class="px-4 py-2 border">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 border">{{ $order->status }}</td>
                                <td class="px-4 py-2 border">{{ $order->created_at->format('d-m-Y') }}</td>
                                @if(Auth::user()->role === 'admin')
                                <td class="px-4 py-2 border">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('dashboard.orders.edit', $order) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded cursor-pointer">Edit</a>
                                        <form action="{{ route('dashboard.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded cursor-pointer">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-2 border text-center">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
