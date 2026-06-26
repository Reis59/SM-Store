<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContohController extends Controller
{
    public function index()
    {
        $products = [
            ['id' => 1, 'name' => 'Product A', 'price' => 100],
            ['id' => 2, 'name' => 'Product B', 'price' => 200],
            ['id' => 3, 'name' => 'Product C', 'price' => 300],
        ];

        $categories = [
            ['id' => 1, 'name' => 'Category A'],
            ['id' => 2, 'name' => 'Category B'],
            ['id' => 3, 'name' => 'Category C'],
        ];

        return view(
            'contoh.index', 
            compact('products', 'categories')
            // ['products' => $products, 'categories' => $categories]
        );
    }
}
