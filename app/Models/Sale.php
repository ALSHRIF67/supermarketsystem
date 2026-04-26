<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id', 'customer_id', 'invoice_number', 'total_amount',
        'discount_amount', 'tax_amount', 'payable_amount', 'paid_amount',
        'payment_method', 'payment_status', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
