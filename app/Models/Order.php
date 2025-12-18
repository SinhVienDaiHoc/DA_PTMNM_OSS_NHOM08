<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'shipping_address',
        'voucher_id'
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function voucher()
{
    return $this->belongsTo(Voucher::class);
}
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            0, 'pending'    => 'Đang chờ xác nhận',
            1, 'processing' => 'Đang chuẩn bị đơn hàng',
            2, 'shipping'   => 'Đang giao hàng',
            3, 'completed'  => 'Hoàn tất',
            4, 'cancelled', 'canceled' => 'Hủy đơn',
            default         => 'Không xác định',
        };
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
public function payment(): HasOne
    {
        return $this->hasOne(Payment::class); 
    }
    public function points(): HasMany
    {
        return $this->hasMany(Point::class, 'order_id');
    }
}

