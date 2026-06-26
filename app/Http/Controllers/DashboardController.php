<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data: total product, total product_category, total order, total user, graph order weekly, table order latest
        $totals_data = [
            [
                'name'=> 'Product',
                'total' => Product::count(),
                'color' => '#dbd8ff',
                'icon_color' => '#7c3aed',
                'icon'=> 'inventory_2',
            ],
            [
                'name'=> 'Product Category',
                'total' => ProductCategory::count(),
                'color' => '#c7d2fe',
                'icon_color' => '#4c1d95',
                'icon'=> 'category',
            ],
            [
                'name'=> 'Order',
                'total' => Order::where('status', 'completed')->count(),
                'color' => '#d1fae5',
                'icon_color' => '#065f46',
                'icon'=> 'shopping_cart',
            ],
            [
                'name'=> 'User',
                'total' => User::count(),
                'color' => '#dbeafe',
                'icon_color' => '#1e3a8a',
                'icon'=> 'people',
            ],
            [
                'name'=>'Product Clicks',
                'total' => Product::sum('clicks'),
                'color' => '#fef3c7',
                'icon_color' => '#78350f',
                'icon' => 'trending_up',
            ]
        ];

        // chart data weekly order (total order per day and total revenue per day in the last 7 days) display in dashbard view with chart js

        $total_7_days_order_data = Order::where('status', 'completed')
            ->whereDate('created_at', '>=', now()->subDays(6)->startOfDay())
            ->whereDate('created_at', '<=', now()->endOfDay())
            ->count();

        $weekly_order_data = $total_7_days_order_data > 0 ? $this->getWeeklyOrderData() : collect([]);

        // table order latest (latest 5 order with order id, customer name, total price, status, order date) display in dashboard view
        $recent_orders = Order::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('dashboard', compact('totals_data', 'weekly_order_data', 'recent_orders', 'total_7_days_order_data'));
    }

    private function getWeeklyOrderData()
    {
        $dates = Collect(range(0, 6))->map(function ($i) {
            return now()->subDays($i)->format('Y-m-d');
        })->reverse()->toArray();

        $weekly_order_data = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_order, SUM(total_price) as total_revenue')
            ->where('status', 'completed')
            ->whereDate('created_at', '>=', now()->subDays(6)->startOfDay())
            ->whereDate('created_at', '<=', now()->endOfDay())
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Fill in missing dates with 0 values
        // $weekly_order_data = collect($dates)->map(function ($date) use ($weekly_order_data) {
        //     return [
        //         'date' => $date,
        //         'total_order' => $weekly_order_data->get($date)->total_order ?? 0,
        //         'total_revenue' => $weekly_order_data->get($date)->total_revenue ?? 0,
        //     ];
        // });
        $data = [];
        foreach($dates as $date) {
            $data[] = [
                'date' => $date,
                'total_order' => $weekly_order_data->get($date)->total_order ?? 0,
                'total_revenue' => $weekly_order_data->get($date)->total_revenue ?? 0,
            ];
        }
        return $data;
    }
}
