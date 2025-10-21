<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'category',
        'image',
    ];

    protected $appends = ['available_quantity'];

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id', 'product_id');
    }

    public function getAvailableQuantityAttribute()
    {
        return $this->inventory ? $this->inventory->quantity_in_stock : 0;
    }
}
