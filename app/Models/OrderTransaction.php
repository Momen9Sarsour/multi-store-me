<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'transaction_id',
        'total_price',
        'admin_percentage',
        'store_owner_percentage',
        'delivery_percentage',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
