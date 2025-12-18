<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
  use HasFactory;

  public $timestamps = true;
  protected $table = 'products';
  protected $fillable = [
    'name',
    'price',
    'stock',
    'description',
    'image_cover',
    'reward_point',
    'user_id',
    'category_id',
  ];

  //========================================
  //RELATIONSHIP

  public function category(): BelongsTo
  {
    // Category Model, Khóa ngoại trong bảng Product (cột hiện tại), Khóa chính trong bảng Category
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }
  // Đặt tên là creator đúng ngữ cảnh cho dễ bảo tri
  public function creator(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }


  public function orderItems(): HasMany
  {
    return $this->hasMany(OrderItem::class);
  }

  public function reviews(): HasMany
  {
    return $this->hasMany(Review::class, 'product_id', 'id');
  }
  //========================================
  //URL của image
  public function getImageAttribute()
  {
    return $this->image_cover;
  }
}
