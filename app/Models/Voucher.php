<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use HasFactory;
    protected $table='vouchers';
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'discount_amount',
        'required_points',
        'max_usage_count',
        'quantity',
        'start_at',
        'expires_at',
        'is_active',      
    ];
    
    //Ép kiểu:
    protected function casts(){
        return[
           'discount_amount' => 'integer',
        'required_points' => 'integer',
        'max_usage_count' => 'integer',
        'quantity' => 'integer',
        'start_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        ];
    }

    
    //====================================
    //RELATIONSHIP
   
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function redemptions(): HasMany
    {
        // PointsRedemption.voucher_id là FK trỏ tới Voucher.id
        return $this->hasMany(PointsRedemption::class, 'voucher_id');
    }
    public function userVouchers(): HasMany
    {
        // UserVoucher.voucher_id là FK trỏ tới Voucher.id
        return $this->hasMany(UserVoucher::class, 'voucher_id');
    }
     //====================================


}
