<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointsRedemption extends Model
{
    use HasFactory;
    protected $table='points_redemptions';
    protected $fillable = [
        'user_id',
        'voucher_id',
        'points_used',
        'status',
        'user_voucher_id',
    ];
     //===========================================
    //RELATIONSHIP
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

   public function voucher():BelongsTo{
    return $this->belongsTo(Voucher::class);
}

// Túi voucher của Customer
public function userVoucher()
    {
        return $this->belongsTo(UserVoucher::class);
    }
    //===========================================
}
