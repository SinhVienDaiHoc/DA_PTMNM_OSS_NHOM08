<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.adminview');
        //===========================
        // STATUS = 3 => HOÀN TẤT
    //     $completedStatus = 3;

    //     // ===== 1) DOANH THU + SỐ LƯỢNG BÁN THEO SẢN PHẨM (CHỈ TÍNH HOÀN TẤT) =====
    //     $productStats = DB::table('order_items')
    //         ->join('products', 'order_items.product_id', '=', 'products.id')
    //         ->join('orders', 'order_items.order_id', '=', 'orders.id')
    //         ->where('orders.status', $completedStatus)
    //         ->select(
    //             'products.id',
    //             'products.name as product_name',
    //             DB::raw('SUM(order_items.quantity) as total_sold'),
    //             DB::raw('SUM(order_items.quantity * products.price) as total_revenue')
    //         )
    //         ->groupBy('products.id', 'products.name')
    //         ->orderByDesc('total_revenue')
    //         ->get();

    //     // ===== 2) TỔNG DOANH THU TRONG THÁNG HIỆN TẠI (CHỈ TÍNH HOÀN TẤT) =====
    //             $currentMonthRevenue = DB::table('orders')
    //             ->where('status', 3)
    //             ->whereMonth('updated_at', now()->month)
    //               ->whereYear('updated_at', now()->year)
    //              ->sum('total');


    //     // ===== 3) DANH SÁCH KHÁCH HÀNG CÓ ĐƠN HOÀN TẤT =====
    //  $customers = DB::table('orders')
    //         ->join('users', 'orders.user_id', '=', 'users.id') // JOIN vào bảng users
    //         ->join('profiles', 'users.id', '=', 'profiles.user_id') // JOIN vào bảng profiles
    //         ->where('orders.status', $completedStatus) // chỉ đơn hoàn tất
    //         ->whereNotNull('orders.user_id') // Đảm bảo đơn hàng có user_id
    //         ->select(
    //             'profiles.full_name', // Lấy tên từ bảng profiles
    //             'profiles.phone_number', // Lấy SĐT từ bảng profiles
    //             DB::raw('COUNT(orders.id) as total_orders'), // Đếm số đơn hàng
    //             DB::raw('MAX(orders.updated_at) as last_order_at') // Lấy thời gian đơn cuối cùng
    //         )
    //         // GROUP BY theo user_id (để nhóm đơn hàng), và các cột hiển thị (full_name, phone_number)
    //         ->groupBy('orders.user_id', 'profiles.full_name', 'profiles.phone_number') 
    //         ->orderByDesc('last_order_at')
    //         ->get();


    //     // ===== 4) TỔNG DOANH THU TẤT CẢ (CHỈ HOÀN TẤT) =====
    //     $totalRevenue = (float) $productStats->sum('total_revenue');

    //     // ===== 5) TRẢ VIEW =====
    //     return view('admin.dashboard.dashboard', compact(
    //         'productStats',
    //         'currentMonthRevenue',
    //         'customers',
    //         'totalRevenue'
    //     ));
    }
}
