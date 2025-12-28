<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PointsRedemption;
use App\Models\UserVoucher;
use Illuminate\Support\Str;
class VoucherExchangeController extends Controller

{
    public function index (){
        $vouchers = Voucher::where('is_active', true)
                           ->where('required_points', '>', 0)
                           ->orderBy('required_points')
                           ->get();

        //ĐIỂM HIỆN TẠI CỦA CUSTOMER
        // $userPoints = Auth::user()->points ?? 0;

        //BACKUP TỪ LAYOUTS.APP
        $userPoints = \Illuminate\Support\Facades\DB::table('points')
            ->where('user_id', Auth::id())
            ->sum('points');

            return view('user-voucher.exchange.index', compact('vouchers', 'userPoints'));
    }
    

    //HÀM ĐỔI DIỂM
    public function exchange(Voucher $voucher)
    {
        $user = Auth::user();
       $userPoints = DB::table('points')
        ->where('user_id', $user->id)
        ->sum('points');
        if ($userPoints < $voucher->required_points) {
            return redirect()->back()->with('error', 'Bạn không đủ điểm để đổi Voucher này.');
        }
        DB::beginTransaction();

    try {
        // A. TẠO VÀ LƯU VOUCHER VÀO TÚI CỦA USER (Bước này phải chạy trước)
        $userVoucher = $this->storeUserVoucher($user, $voucher); 

        // B. Ghi lại bản ghi TRỪ ĐIỂM vào bảng 'points'
        $pointsRedeemed = $voucher->required_points; 
        
        // Ghi lại giao dịch trừ điểm (số âm)
        DB::table('points')->insert([
            'user_id' => $user->id,
            'points' => -$pointsRedeemed,
            'type' => 0, // Quy ước: 0 là trừ điểm
            'description' => 'Đổi voucher thành công', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        PointsRedemption::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'points_used' => $pointsRedeemed, // Số dương
            'status'=>1,
            'user_voucher_id' => $userVoucher->id,
        ]);
      
        DB::commit(); 

      return redirect()->route('user.vouchers.show', $userVoucher->id)
                         ->with('success', 'Đổi voucher thành công! Điểm của bạn đã được trừ.');

   } catch (\Exception $e) {
        DB::rollBack(); 
        return redirect()->back()->with('error', 'Đổi voucher thất bại do lỗi hệ thống.');
    }

}
private function storeUserVoucher($user, $voucher)
    {
        // Đảm bảo mã code là duy nhất trong vòng lặp
        do {
            $uniqueCode = Str::upper(Str::random(16)); 
        } while (UserVoucher::where('code', $uniqueCode)->exists());
        
        // Tạo bản ghi UserVoucher
        return UserVoucher::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'code' => $uniqueCode,
            'used_at' => null,
        ]);
    }


}
