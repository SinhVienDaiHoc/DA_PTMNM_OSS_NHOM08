<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Voucher;
use App\Models\Profile;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show()
    {
        //Tính tiền nếu customer ko áp mã giảm giá
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        //==================================================
        //Lấy thông tin từ profile
        $user = Auth::user();
        $profile = $user->profile ?? null;
        return view('checkout.thanhtoan', compact('total', 'profile'));
    }

    public function process(Request $request)
    {
        $order = null; //khởi tạo
        $user = Auth::user();

        // Lấy profile, có thể là null
        $profile = $user->profile;



        if (!$profile) {
            $profile = Profile::create([
                'user_id' => $user->id,
                'full_name' => $request->input('customer_name', $user->name ?? 'Người dùng mới'),
                'phone_number' => $request->input('customer_phone', null),
                'address' => $request->input('customer_address', null),
            ]);
            $user->profile = $profile;;
        }
        // Lấy giỏ hàng từ session
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng đang trống.');
        }

        // === KIỂM TRA TỒN KHO  ===
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('cart.index')
                    ->with('error', 'Xin lỗi, sản phẩm "' . $item['name'] . '" hiện chỉ còn ' . $product->stock . ' cái. Vui lòng cập nhật lại số lượng!');
            }
        }

        // TÍNH TỔNG TIỀN ( ko có voucher)
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        //TÍNH TỔNG TIỀN ( có voucher)
        $finalTotal = $total;
        $voucherId = null;
        $discountAmount = 0;

        $profile->full_name = $request->input('customer_name', $profile->full_name);
        $profile->phone_number = $request->input('customer_phone', $profile->phone_number);
        $profile->address = $request->input('customer_address', $profile->address);
        $profile->save();

        //LOGIC XỬ LÍ VOUCHER
        $voucherCode = trim($request->input('voucher_code'));
        $voucher = null;
        $userVoucher = null;
        if (!empty($voucherCode)) {

            $userVoucher = \Illuminate\Support\Facades\DB::table('user_vouchers')
                ->where('code', $voucherCode)
                ->where('user_id', Auth::id())
                ->whereNull('used_at')
                ->first();
            if ($userVoucher) {
                $voucher = Voucher::where('id', $userVoucher->voucher_id)
                    ->where('is_active', true)
                    ->first();
            } else {
                $voucher = Voucher::where('code', $voucherCode)
                    ->where('is_active', true)
                    ->first();
            }

            if (!$voucher) {
                return back()->withInput()->with('error', 'Mã giảm giá không tồn tại hoặc không hoạt động.');
            }

            //Kiểm tra hạn sử dụng
            $now = now();
            if ($voucher->expires_at && $voucher->expires_at->lt($now)) {
                return back()->withInput()->with('error', 'Mã giảm giá đã hết hạn sử dụng.');
            }
            if ($voucher->start_at && $voucher->start_at->gt($now)) {
                return back()->withInput()->with('error', 'Mã giảm giá chưa đến ngày bắt đầu sử dụng.');
            }

            // Kiểm tra lượt dùng 
            if (!$userVoucher && $voucher->max_usage_count > 0 && $voucher->orders()->count() >= $voucher->max_usage_count) {
                return back()->withInput()->with('error', 'Mã giảm giá chung này đã hết lượt sử dụng.');
            }

            //Tính toán giảm giá
            if ($voucher->type === 'fixed') {
                $discountAmount = $voucher->discount_amount;
            } elseif ($voucher->type === 'percentage') {
                $discountAmount = ($total * $voucher->discount_amount) / 100;
            }

            //Áp dụng giảm và lưu 
            $finalTotal = max(0, $total - $discountAmount);
            $voucherId = $voucher->id;
            // Lưu discount vào session để hiển thị trong View (Tùy chọn)
            session()->flash('discount', $discountAmount);
            $request->session()->flash('success', 'Đã áp dụng mã giảm giá thành công. Bạn được giảm: ' . number_format($discountAmount, 0, ',', '.') . ' đ');
        }
        //Xử lí PAYMENT
        $paymentMethod = $request->input('payment_method', 'cash');
        $paymentStatus = ($paymentMethod === 'cash') ? 'success' : 'pending';


        // TẠO ĐƠN HÀNG
        $order = \App\Models\Order::create([
            'user_id'          => Auth::id(),
            'total'            => $finalTotal,            // <--- DÒNG NÀY RẤT QUAN TRỌNG
            'status'           => 0,
            'shipping_address' => $request->input('customer_address', optional($profile)->address),
            'voucher_id'         => $voucherId,
        ]);

        Payment::create([ // <<<--- TẠO BẢN GHI TRONG BẢNG PAYMENTS
            'order_id'       => $order->id, // Liên kết khóa ngoại
            'payment_method' => $paymentMethod,
            'amount'         => $finalTotal,
            'status'         => $paymentStatus,
            'paid_at'        => ($paymentStatus === 'success') ? now() : null,
        ]);

        if ($userVoucher) {
            \Illuminate\Support\Facades\DB::table('user_vouchers')
                ->where('id', $userVoucher->id)
                ->update(['used_at' => now()]);
        }

        $totalRewardPoints = 0;

        // LƯU CÁC SẢN PHẨM TRONG ĐƠN
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'       => $order->id,
                'product_id'     => $productId,
                'quantity'       => $item['quantity'],
                'price_at_order' => $item['price'],
            ]);
            $product = Product::find($productId);
            if ($product) {

                if ($product->stock >= $item['quantity']) {
                    $product->decrement('stock', $item['quantity']);
                }

                $pointsOfThisProduct = $product->reward_point;

                if ($pointsOfThisProduct == null) {
                    $pointsOfThisProduct = 0;
                }
                $totalRewardPoints += ($pointsOfThisProduct * $item['quantity']);
            }
        }


        if ($totalRewardPoints > 0) {
            \App\Models\Point::create([
                'user_id'     => Auth::id(),
                'order_id'    => $order->id,
                'points'      => $totalRewardPoints,
                'type'        => 1,
                'description' => "Tích điểm từ đơn hàng #{$order->id}",
            ]);
        }


        session()->forget('cart');

        // Thông báo thành công kèm số điểm nhận được
        $message = 'Đặt hàng thành công!';
        if ($totalRewardPoints > 0) {
            $message .= " Bạn nhận được +{$totalRewardPoints} điểm tích lũy.";
        }


        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Đặt hàng thành công!');
    }
}
