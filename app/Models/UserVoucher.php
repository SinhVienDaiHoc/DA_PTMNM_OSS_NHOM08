<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class UserVoucher extends Model
{
    protected $table = 'user_vouchers';
    protected $fillable = [
        'user_id',
        'voucher_id',
        'code',
        'used_at',
    ];
    //kết nối đến users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //kết nối đến Vouchers
    public function voucher()
    {
        return $this->belongsTo(Voucher::class); 
    }

    //kết nối đến PointsRedemptions
    public function pointsRedemption(): HasOne
    {
        return $this->hasOne(PointsRedemption::class, 'user_voucher_id'); 
    }

    
}
