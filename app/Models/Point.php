<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    use HasFactory;
    protected $table='points';
    protected $fillable = [
      'user_id',
        'order_id',
        'points',
        'type',
        'description',
    ];
     //=======================================
    //RELATIONSHIP
public function user():BelongsTo{
    return $this->belongsTo(User::class);
}

public function order():BelongsTo{
    return $this->belongsTo(Order::class);
}
    //=======================================

}
