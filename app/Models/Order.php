<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id','order_date','total_price','order_status',
    ];

    protected $casts = [
        'order_date'  => 'datetime',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}