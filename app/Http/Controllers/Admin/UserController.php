<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    public function index()
    {

        $users = User::with('profile')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.user.index', compact('users'));
    }
    //LOAD PROFILE
    public function show(User $user)
    {
        //LOAD TỪ PROFILE
        $user->load([
            'profile',
            'orders' => function ($query) {
                // Chỉ lấy 10 đơn hàng gần nhất, sắp xếp giảm dần
                $query->orderByDesc('created_at')->limit(10);
            },
            'usedVouchers' => function ($query) {
                // Nạp thêm thông tin voucher gốc và chi tiết đổi điểm
                $query->with(['voucher', 'pointsRedemption'])->orderByDesc('created_at');
            }
        ]);
        $currentPoints = DB::table('points')
            ->where('user_id', $user->id)
            ->sum('points');

        return view('admin.user.show', compact('user', 'currentPoints'));
    }
}
