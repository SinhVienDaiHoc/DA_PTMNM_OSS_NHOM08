    @extends('layouts.app')

    @section('title', 'Chi tiết đơn hàng')

    @section('content')
    <div class="mb-3">
        <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
    <div class="py-4" style="background:#fbf1e0;">
        <div class="container container-wide">

            <h3 class="mb-3 fw-bold">Đơn hàng #{{ $order->id }}</h3>

            <p><strong>Trạng thái:</strong> {{ $order->status_text }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Họ tên:</strong> {{ $order->user->profile->full_name ?? $order->user->name ?? 'Khách vãng lai' }}</p>
            <p><strong>SĐT:</strong> {{ $order->user->profile->phone_number ?? 'Chưa cập nhật' }}</p>
            <p><strong>Địa chỉ: </strong>{{ $order->shipping_address ?? 'Tại cửa hàng' }}</p>
            <p><strong>Thanh toán:</strong>
                {{ $order->payment_method == 'bank_transfer' ? 'Chuyển khoản' : 'Tiền mặt' }}
            </p>

            @php
            $calculatedTotal = $order->items->sum('subtotal');
            $totalToShow = $calculatedTotal ?: $order->total;
            @endphp

            <h5 class="mt-4">Sản phẩm</h5>
            <table class="table bg-white">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ number_format($item->price_at_order, 0, ',', '.') }} đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->subtotal, 0, ',', '.') }} đ</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-3">
                            Không có sản phẩm nào trong đơn hàng.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <p><strong>Tổng cộng:</strong> {{ number_format($totalToShow, 0, ',', '.') }} đ</p>

        </div>
    </div>
    @endsection