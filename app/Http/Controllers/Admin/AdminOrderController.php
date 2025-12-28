<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(10);

        return view('admin.adminorders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,3,4',
        ]);

        $newStatus = (int) $request->input('status');
        $oldStatus = (int) $order->status;

        // Cập nhật status
        $order->status = $newStatus;
        $order->save();

        /**
         *  CỘNG ĐIỂM THƯỞNG
         * Chỉ cộng khi chuyển sang Hoàn tất
         * - Quy đổi: 100.000đ => 100 điểm => 1.000đ => 1 điểm
         */
        if ($newStatus === 3 && $order->user_id) {

            $total = (int) $order->total;
            $rewardPoints = intdiv($total, 1000);

            // Nếu đơn quá nhỏ thì khỏi cộng <1d
            if ($rewardPoints > 0) {

                $alreadyAwarded = DB::table('points')
                    ->where('user_id', $order->user_id)
                    ->where('order_id', $order->id)
                    ->where('type', 1)
                    ->exists();

                if (!$alreadyAwarded) {
                    DB::table('points')->insert([
                        'user_id'     => $order->user_id,
                        'order_id'    => $order->id,
                        'points'      => $rewardPoints,
                        'type'        => 1,
                        'description' => "Cộng điểm cho đơn #{$order->id} (Hoàn tất)",
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
