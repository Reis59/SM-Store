<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $cart_items = CartItem::with('product')
                            ->where('user_id', Auth::id())
                            ->whereHas('product', function($query) {
                                $query->where('stock', '>', 0);
                            })
                            ->get();
            $cart_items_sold = CartItem::with('product')
                            ->where('user_id', Auth::id())
                            ->whereHas('product', function($query) {
                                $query->where('stock', '=', 0);
                            })
                            ->get();
            return view('cart.index', compact('cart_items', 'cart_items_sold'));
        }else{   
            return redirect()->route('login')->withError('Anda harus login untuk melihat keranjang.');
        }
    }

    public function add(Request $request, int $id)
    {
        $product = Product::findOrFail($id);
        if(Auth::check()){
            $cart_item = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->first();
            if($cart_item){
                $cart_item->quantity += $request->input('quantity', 1);
                $cart_item->save();
            }else{
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $request->input('quantity', 1),
                ]);
            }
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        }else{
            return redirect()->route('login')->withError('Anda harus login untuk menambahkan produk ke keranjang.');
        }
    }

    public function update(Request $request, int $id)
    {
        if(Auth::check()){
            $cart_item = CartItem::where('user_id', Auth::id())
                            ->where('id', $id)
                            ->first();
            if($cart_item){
                $cart_item->quantity = $request->input('quantity', 1);
                $cart_item->save();
                return redirect()->back()->with('success', 'Jumlah produk berhasil diperbarui.');
            }else{
                return redirect()->back()->withError('Produk tidak ditemukan di keranjang.');
            }
        }else{
            return redirect()->route('login')->withError('Anda harus login untuk memperbarui jumlah produk di keranjang.');
        }
    }

    public function remove(int $id)
    {
        if(Auth::check()){
            $cart_item = CartItem::where('user_id', Auth::id())
                            ->where('id', $id)
                            ->first();
            if($cart_item){
                $cart_item->delete();
                return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
            }else{
                return redirect()->back()->withError('Produk tidak ditemukan di keranjang.');
            }
        }else{
            return redirect()->route('login')->withError('Anda harus login untuk menghapus produk dari keranjang.');
        }
    }
}
