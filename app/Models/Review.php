<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PHPUnit\Metadata\Before;

class Review extends Model
{
    use HasFactory;
    protected $table='reviews';
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',

    ];
    //=========================================
    //RELATIONSHIP
public function product():BelongsTo{
        return $this->belongsTo(Product::class, 'product_id', 'id');
}

public function user():BelongsTo{
    return $this->belongsTo(User::class);
}

    //=========================================

}
