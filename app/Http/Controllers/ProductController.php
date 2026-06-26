<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $products = Product::with('category')
            ->withCount(['orderItems' => function($query) {
                $query->whereHas('order', function($query) {
                    $query->where('status', 'completed');
                });
            }])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->when($sort, function ($query, $sort) {
                switch ($sort) {
                    case 'asc':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'best_seller':
                        $query->orderBy('order_items_count', 'desc');
                        break;
                    case 'stock_low':
                        $query->orderBy('stock', 'asc');
                        break;
                    case 'stock_high':
                        $query->orderBy('stock', 'desc');
                        break;
                };
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('dashboards.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::select('id', 'name')->get();
        return view('dashboards.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //cropped_image is base64 string
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            // 'image' => 'required|image|max:2048',
            'cropped_image' => 'required|string',
        ]);

        $slug = Str::slug($request->name);

        //check if slug already exists
        if(Product::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(5);
        }

        $imagePath = 'products/';

        // storage disk in local is in 'images' and in production we can use s3 or other cloud storage, just change the disk in config/filesystem.php and .env
        $disk = env('APP_ENV') === 'local' ? 'images' : 'google_cloud_storage';
        

        // cropped_image is base64 string, we need to decode it and save it to storage
        // custome filename with timestamp and random string
        $fileName = time() . '_' . Str::random(10) . '.webp';
        // decode base64 string
        $binaryData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->cropped_image));
        Storage::disk($disk)->put($imagePath . $fileName, $binaryData);

        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath . $fileName,
            'product_category_id' => $request->product_category_id,
        ]);

        return redirect()->route('dashboard.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $product = Product::with('category')
                        ->where('slug', $slug)
                        ->firstOrFail();
        $related_products = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        
        // Click tracking using session to prevent multiple clicks from the same user in a short period of time
        $sessionKey = 'product_click_' . $product->id;
        if (!session()->has($sessionKey)) {
            $product->clicks += 1;
            $product->save();
            session()->put($sessionKey, true);
        }

        return view('product.show', compact('product', 'related_products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::select('id', 'name')->get();
        return view('dashboards.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|max:2048',
            'cropped_image' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);

        //check if slug already exists
        if(Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug .= '-' . Str::random(5);
        }

        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_category_id' => $request->product_category_id,
        ];

        if ($request->image) {
            // check image exist in storage
            $storage = Storage::disk(env('APP_ENV') === 'local' ? 'images' : 'google_cloud_storage');

            if($storage->exists($product->image)) {
                // delete old image from storage
                $storage->delete($product->image);
            }

            // save new image
            $imagePath = 'products/';
            $fileName = time() . '_' . Str::random(10) . '.webp';
            $binaryData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->cropped_image));
            $storage->put($imagePath . $fileName, $binaryData);

            $data['image'] = $imagePath . $fileName;
        }

        $product->update($data);

        return redirect()->route('dashboard.products.index')->with('success', 'Product with id ' . $product->id . ' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // check if product has order items
        if ($product->orderItems()->count() > 0) {
            return back()->withErrors(['error' => 'Product with id ' . $product->id . ' cannot be deleted because it has order items.']);
        }

        // check image exist in storage
        $storage = Storage::disk(env('APP_ENV') === 'local' ? 'images' : 'google_cloud_storage');

        if($storage->exists($product->image)) {
            // delete old image from storage
            $storage->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Product with id ' . $product->id . ' deleted successfully.');
    }
}
