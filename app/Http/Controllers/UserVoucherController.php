<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserVoucher;
use Illuminate\Support\Facades\Auth;

class UserVoucherController extends Controller
{
    public function index()
    {
        $userVouchers = UserVoucher::where('user_id', Auth::id())
          
            ->with(['voucher', 'pointsRedemption']) 
            ->orderByDesc('created_at')
            ->get();
            
        return view('user-voucher.index', compact('userVouchers'));
    }
    public function show(UserVoucher $userVoucher)
    {
        
        // Bạn có thể thêm logic kiểm tra xem $userVoucher có thuộc về Auth::user() không 
        if ($userVoucher->user_id !== Auth::id()) {
            abort(403); 
        }

        return view('user-voucher.show', compact('userVoucher'));
    }

}
