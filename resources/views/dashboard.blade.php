<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Dashboard Overview') }}
            </h2>
            <span class="text-sm text-gray-500 font-medium">Hari ini: {{ date('d M Y') }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                @foreach($totals_data as $data)
                    <div class="p-5 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center gap-4 transition-all duration-300 hover:shadow-md">
                        <div class="p-3 rounded-xl flex items-center justify-center" style="background-color: {!! $data['color'] !!}15;">
                            <span class="material-icons text-3xl" style="color: {!! $data['icon_color'] !!}">{{ $data['icon'] }}</span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ $data['name'] }}</p>
                            <h2 class="text-2xl font-bold text-gray-800 mt-0.5">{{ $data['total'] }}</h2>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Tren Penjualan & Pendapatan</h3>
                    <p class="text-xs text-gray-500">Analisis performa mingguan toko Anda</p>
                </div>
                <div class="w-full">
                    <canvas id="weeklyOrderChart" class="max-h-[350px]"></canvas>
                </div>
            </div>

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Recent Orders</h3>
                        <p class="text-xs text-gray-500">Kelola pesanan terbaru yang masuk</p>
                    </div>
                    <a href="{{ route('dashboard.orders.index') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                        View All Orders 
                        <span class="material-icons text-sm ml-1">arrow_forward</span>
                    </a>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Amount</th>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Order Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 even:bg-gray-50/50">
                        @forelse($recent_orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-3.5 px-4 text-sm font-semibold text-gray-700">#{{ $order->order_number }}</td>
                                <td class="py-3.5 px-4 text-sm text-gray-600 font-medium">{{ $order->name }}</td>
                                <td class="py-3.5 px-4 text-sm font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 text-sm">
                                    @php
                                        $statusClass = match(strtolower($order->status)) {
                                            'completed', 'success' => 'bg-green-50 text-green-700 border-green-200',
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            default => 'bg-gray-50 text-gray-700 border-gray-200'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full border {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-4 text-sm text-center text-gray-400">
                                    <span class="material-icons text-3xl block mb-2 text-gray-300">shopping_bag</span>
                                    No recent orders found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@push('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js" integrity="sha256-SERKgtTty1vsDxll+qzd4Y2cF9swY9BCq62i9wXJ9Uo=" crossorigin="anonymous"></script>
<script>
    const rupiahFormatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    });
    let weeklyOrderData = @json($weekly_order_data);
    let ctx = document.getElementById('weeklyOrderChart').getContext('2d');
    
    // Perbaikan Gradien warna Chart agar estetik
    let orderGradient = ctx.createLinearGradient(0, 0, 0, 300);
    orderGradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
    orderGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    let revenueGradient = ctx.createLinearGradient(0, 0, 0, 300);
    revenueGradient.addColorStop(0, 'rgba(239, 68, 68, 0.2)');
    revenueGradient.addColorStop(1, 'rgba(239, 68, 68, 0)');

    let weeklyOrderChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: weeklyOrderData.map(data => data.date),
            datasets: [
                {
                    label: 'Total Orders',
                    data: weeklyOrderData.map(data => data.total_order),
                    borderColor: '#3b82f6',
                    backgroundColor: orderGradient,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2,
                    yAxisID: 'y'
                },
                {
                    label: 'Total Revenue',
                    data: weeklyOrderData.map(data => data.total_revenue),
                    borderColor: '#ef4444',
                    backgroundColor: revenueGradient,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { boxWidth: 12, font: { weight: 'bold' } }
                }
            },
            scales: {
                x: { grid: { display: false } },
                'y': {
                    beginAtZero: true,
                    title: { display: true, text: 'Order Count' }
                },
                'y1': {
                    position: 'right',
                    beginAtZero: true,
                    grid: { drawOnChartArea: false },
                    ticks: { callback: function(value) { return rupiahFormatter.format(value); } }
                }
            }
        }
    });
</script>
@endpush
</x-app-layout>