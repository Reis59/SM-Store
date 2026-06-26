<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Home Page';
        $categories = ProductCategory::all();
        $products = Product::with('category');
        
        if($request->has('category') && !empty($request->category)) {
            $products->whereHas('category', function($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        if($request->has('search')) {
            $products->where('name', 'like', '%'. $request->search . '%');
        }

        if(
            $request->has('sort') 
            && in_array($request->sort, ['asc', 'desc'])
        ) {
            $products->orderBy('price', $request->sort);
        }

        // terlaris
        if($request->has('sort') && $request->sort == 'best_seller') {
            $products->withCount(['orderItems' => function($query) {
                    $query->whereHas('order', function($query) {
                        $query->where('status', 'completed');
                    });
                }])
                ->orderBy('order_items_count', 'desc');
        }

        if($request->has('sort') && $request->sort == 'review_positive') {
            $products->whereHas('reviews', function($query) {
                $query->where('rating', '>=', 4);
            });
        }

        $products = $products->paginate(15);

        return view('home', compact('title', 'products', 'categories'));
    }
}
