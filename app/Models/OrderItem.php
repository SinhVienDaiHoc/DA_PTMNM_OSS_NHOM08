<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',   
        'quantity',
        'price_at_order',
    ];
        //RELATIONSHIP
//================================================
public function order()
{
    return $this->belongsTo(Order::class);
}

public function product():BelongsTo{
    return $this->belongsTo(Product::class,'product_id','id');
}

// Thành tiền = đơn giá * số lượng
public function getSubtotalAttribute()
{
    return $this->price_at_order * $this->quantity;
}
//================================================
}
