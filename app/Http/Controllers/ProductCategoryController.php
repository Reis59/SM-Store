<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ORM 
        $categories = ProductCategory::withCount([
            'products', // products_count
            'products as total_stock' => function($query) {
                $query->select(DB::raw("SUM(stock)"));
            },
            'products as total_value' => function($query) {
                $query->select(DB::raw("SUM(price * stock)"));
            }
        ])
        ->when($request->input('search'), function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->when($request->input('sort'), function ($query, $sort) {
            switch ($sort) {
                case 'products_count_desc':
                    $query->orderBy('products_count', 'desc');
                    break;
                case 'products_count_asc':
                    $query->orderBy('products_count', 'asc');
                    break;
                case 'total_stock_desc':
                    $query->orderBy('total_stock', 'desc');
                    break;
                case 'total_stock_asc':
                    $query->orderBy('total_stock', 'asc');
                    break;
                case 'total_value_desc':
                    $query->orderBy('total_value', 'desc');
                    break;
                case 'total_value_asc':
                    $query->orderBy('total_value', 'asc');
                    break;
            };
        })
        ->paginate(5);

        return view('dashboards.product_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:100|min:3|unique:product_categories,name',
            '_token' => 'required',
        ]);
        
        // Makanan dan minuman -> makanan-dan-minuman
        $slug = strtolower(str_replace(' ', '-', $request->name));
        
        // Check if slug already exists
        if (ProductCategory::where('slug', $slug)->exists()) {
            return redirect()->back()->withErrors(['name' => 'Category name already exists.'])->withInput();
        }

        // Simpan kategori baru
        ProductCategory::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        // $category = new ProductCategory();
        // $category->name = $request->name;
        // $category->slug = $slug;
        // $category->save();

        // return redirect()->route('dashboard.product-categories.index')->with('success', 'Category created successfully.');

        return back()->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:3|unique:product_categories,name,' . $productCategory->id,
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->name));
        if (ProductCategory::where('slug', $slug)->where('id', '!=', $productCategory->id)->exists()) {
            return redirect()->back()->withErrors(['name' => 'Category name already exists.'])->withInput();
        }

        $productCategory->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return back()->with('success', 'Category with id ' . $productCategory->id . ' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        // check if category has products
        if ($productCategory->products()->count() > 0) {
            //delete all products in this category
            // $productCategory->products()->delete();
            
            // put null value to product_category_id in products table where product_category_id is the id of the category we want to delete
            // $productCategory->products()->update(['product_category_id' => null]);

            return back()->withErrors(['error' => 'Category with id ' . $productCategory->id . ' cannot be deleted because it has products. Please delete or move the products to another category first.']);
        }
        
        $productCategory->delete();
        return back()->with('success', 'Category with id ' . $productCategory->id . ' deleted successfully.');
    }
}
