<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
   public function index()
{
    $orders = Order::with('items')   
        ->where('user_id', Auth::id())
        ->orderByDesc('created_at')
        ->get();

    return view('orders.donhang', compact('orders'));
}


    public function show($id)
    {
        $order = Order::with('items')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.chitietdonhang', compact('order'));
    }



    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Đã xoá đơn hàng khỏi lịch sử.');
    }

    
}
