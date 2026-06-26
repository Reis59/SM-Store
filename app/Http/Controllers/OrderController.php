<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->withError('Anda harus login untuk melihat pesanan.');
        }

        $orders = Order::with(['orderItems.product'])->orderBy('created_at', 'desc');

        // Jika yang login adalah customer biasa
        if (Auth::user()->role === 'customer') {
            $orders->where('user_id', Auth::id());
            $orders = $orders->get(); // Ambil semua data untuk riwayat customer

            // Diarahkan ke file resources/views/orders/index.blade.php yang baru kita buat
            return view('orders.index', compact('orders'));
        }
        
        // Jika yang login adalah Admin (ke halaman dashboard)
        $orders = $orders->paginate(10);
        return view('dashboards.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()){
            $cart_items = self::getCartItems();

            if($cart_items->isEmpty()){
                return redirect()->route('cart')->withError('Keranjang Anda kosong atau semua produk dalam keranjang sudah habis.');
            }
            $user = Auth::user();
            return view('orders.checkout', compact('cart_items', 'user'));
        }else{
            return redirect()->route('login')->withError('Anda harus login untuk melakukan checkout.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $cart_items = self::getCartItems();

        if($cart_items->isEmpty()){
            return redirect()->route('cart')->withError('Keranjang Anda kosong atau semua produk dalam keranjang sudah habis.');
        }

        $total_price = $cart_items->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // order id with time and date combined with random number
        $order_number = 'ORD-' . date('YmdHis') . '-' . rand(1000, 9999);

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'total_price' => $total_price,
            'order_number' => $order_number,
        ]);

        foreach($cart_items as $item){
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Kurangi stok produk
            $item->product->decrement('stock', $item->quantity);
        }

        // Hapus semua item di keranjang
        CartItem::where('user_id', Auth::id())
                ->whereIn('id', $cart_items->pluck('id')->toArray())
                ->delete();

        // save phone and address to user profile
        $user = User::findOrFail(Auth::id());
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('order.invoice', ['order_number' => $order->order_number])->with('success', 'Pesanan berhasil dibuat!');
    }

    public function invoice(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();
        return view('orders.invoice', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('dashboards.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->status = $request->status;
        $order->save();

        return redirect()->route('dashboard.orders.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Kembalikan stok produk jika pesanan dibatalkan
        if($order->status !== 'cancelled'){
            foreach($order->orderItems as $item){
                $item->product->increment('stock', $item->quantity);
                $item->delete();
            }
        }

        $order->delete();
        return redirect()->route('dashboard.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    private function getCartItems()
    {
        return CartItem::with('product')
                        ->where('user_id', Auth::id())
                        ->whereHas('product', function($query) {
                            $query->where('stock', '>', 0);
                        })
                        ->get();
    }
}
