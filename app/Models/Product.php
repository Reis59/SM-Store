<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'clicks', // Tambahkan kolom clicks ke dalam fillable
        'product_category_id', // Pastikan ini sesuai dengan nama kolom foreign key di database
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // factory() method untuk menghubungkan dengan ProductFactory
    protected static function factory()
    {
        return \Database\Factories\ProductFactory::new();
    }
}
