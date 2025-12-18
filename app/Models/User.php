<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',//Phân role Admin=1, customer =0
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    //=============================================
    //KIỂM TRA ADMIN OR CUSTOMER
    public function isAdmin(): bool
    {
        return $this->role === 1;
    }
    public function isCustomer():bool{
        return $this->role ===0;
    }
    //=============================================
   
    //RELATIONSHIP
    //xem giỏ hàng
    public function cart():HasOne{
        return $this->hasOne(Cart::class);
    }

    //kết nối để xem điểm tích lũy
    public function points():HasMany{
        return $this->hasMany(Point::class);
    }


//kết nối để lấy các voucher mà user này đã dùng
public function usedVouchers()
{
    return $this->hasMany(UserVoucher::class);
}

//xem đơn đặt hàng
    public function orders()
{
    return $this->hasMany(Order::class);
}

//xem giao dịch đổi điểm
    public function redemptions():HasMany{
        return $this->hasMany(PointsRedemption::class);
    }

    public function reviews():HasMany{
        return $this->hasMany(Review::class);
    }

    //xem profile
    public function profile(): HasOne
{
    
    return $this->hasOne(Profile::class);
}
    //===========================================================
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
