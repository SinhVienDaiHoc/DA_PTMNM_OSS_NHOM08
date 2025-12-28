<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Log;

class AdminVoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::withCount('orders')
            ->orderByDesc('id')
            ->paginate(10);

        // Trả về view admin/vouchers/index.blade.php
        return view('admin.voucher.index', compact('vouchers'));
    }


    public function create()
    {
        return view('admin.voucher.create');
    }


    public function store(Request $request)
    {
        // 1. Validation 
        $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:191',
            'name' => 'required|string|max:191',
            'type' => 'required|in:percentage,fixed,gift',
            // Giá trị giảm (hoặc ID quà tặng), phải là số nguyên dương
            'discount_amount' => 'required|integer|min:0',
            'min_order_amount' => 'nullable|integer|min:0',
            'required_points' => 'nullable|integer|min:0',
            'quantity' => 'nullable|integer|min:1',
            'expires_at' => 'required|date|after_or_equal:start_at',
            'start_at' => 'required|date',
        ]);
        try {
            // 2. Tạo Voucher
            Voucher::create([
                'code' => strtoupper($request->code), // Viết hoa mã
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'discount_amount' => $request->discount_amount,
                'min_order_amount' => $request->min_order_amount ?? 0,
                'required_points' => $request->required_points ?? 0,
                'quantity' => $request->quantity,
                'start_at' => $request->start_at,
                'expires_at' => $request->expires_at,
                'is_active' => $request->has('is_active'),
            ]);
            return redirect()->route('admin.voucher.index')->with('success', 'Tạo mã giảm giá thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo Voucher: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi hệ thống: Không thể lưu mã giảm giá. Vui lòng kiểm tra lại Model fillable.');
        }
    }

    /**
     * Hiển thị form chỉnh sửa Voucher
     */
    public function edit(Voucher $voucher)
    {
        return view('admin.voucher.edit', compact('voucher'));
    }


    /** * Cập nhật Voucher trong Database
     */
    public function update(Request $request, Voucher $voucher)
    {
        // 1. Validation (Bỏ qua mã code hiện tại khi kiểm tra unique)
        $request->validate([
            'code' => 'required|string|max:191|unique:vouchers,code,' . $voucher->id,
            'name' => 'required|string|max:191',
            'type' => 'required|in:percentage,fixed,gift',
            'discount_amount' => 'required|integer|min:0',
            'min_order_amount' => 'nullable|integer|min:0',
            'required_points' => 'nullable|integer|min:0',
            'quantity' => 'nullable|integer|min:1',
            'expires_at' => 'required|date|after_or_equal:start_at',
            'start_at' => 'required|date',
        ]);

        // 2. Cập nhật
        $voucher->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'discount_amount' => $request->discount_amount,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'required_points' => $request->required_points ?? 0,
            'quantity' => $request->quantity,
            'start_at' => $request->start_at,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.voucher.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }


    /** Xóa Voucher khỏi Database
     */
    public function destroy(Voucher $voucher)
    {
        // Kiểm tra nếu voucher đã được sử dụng
        if ($voucher->orders()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa mã giảm giá này vì đã có đơn hàng sử dụng!');
        }

        if ($voucher->delete()) {
            // Redirect về index và gửi thông báo thành công
            return redirect()->route('admin.voucher.index')->with('success', 'Xóa mã giảm giá thành công!');
        }
        return redirect()->back()->with('error', 'Xóa mã giảm giá thất bại.');
    }

    //==========================================
    public function stats(Voucher $voucher)
    {
        // Lấy orders đã dùng voucher, eager load user và phân trang
        $usedOrders = $voucher->orders()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(20);

        // Tính tổng số lượt dùng
        $totalUsageCount = $voucher->orders()->count();

        return view('admin.voucher.stats', compact('voucher', 'usedOrders', 'totalUsageCount'));
    }
    //==========================================











}
