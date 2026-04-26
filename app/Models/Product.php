<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'barcode', 'description',
        'purchase_price', 'sale_price', 'wholesale_price',
        'stock_quantity', 'low_stock_threshold', 'expiry_date',
        'image_path', 'is_active'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
    }

    public function scopeExpiringSoon($query)
    {
        return $query->where('expiry_date', '<=', now()->addMonths(3))
                     ->where('expiry_date', '>', now());
    }
}
