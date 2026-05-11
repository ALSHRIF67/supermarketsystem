<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'location', 'is_active'];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
