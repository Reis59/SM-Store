<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('contoh', [App\Http\Controllers\ContohController::class, 'index']
// );

// Route::resource('crud', App\Http\Controllers\CRUDController::class);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('detail-product/{slug}', [ProductController::class, 'show'])->name('detail-product');

Route::prefix('cart')->group(function (){
    Route::get('/', [CartController::class, 'index'])->name('cart');
    Route::get('add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    // Pastikan kodenya ditambahkan ->name('cart.index') di bagian paling akhir
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});

Route::get('checkout', [OrderController::class, 'create'])->name('checkout');
Route::post('create-order', [OrderController::class, 'store'])->name('order.store');
Route::get('invoice/{order_number}', [OrderController::class, 'invoice'])->name('order.invoice');

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/products', ProductController::class)->names('dashboard.products');
        Route::resource('/product-categories', ProductCategoryController::class)->names('dashboard.product-categories')->except(['create', 'edit']);
        Route::resource('/orders', OrderController::class)->names('dashboard.orders');
    });
    Route::get('order-list', [OrderController::class, 'index'])->name('order.list');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';