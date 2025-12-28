@extends('admin.adminview')

@section('title', 'Thống Kê Voucher')
@section('page_title', 'Thống Kê Sử Dụng: ' . $voucher->code)

@section('content')

<a href="{{ route('admin.voucher.index') }}" class="btn btn-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Quay lại Danh sách
</a>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h5 class="card-title">Mã Voucher</h5>
                <p class="card-text fs-3 fw-bold">{{ $voucher->code }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h5 class="card-title">Tổng Lượt Đã Dùng</h5>
                <p class="card-text fs-3 fw-bold">{{ $totalUsageCount }} / {{ $voucher->quantity ?? 'Không giới hạn' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h5 class="card-title">Tổng Tiền Giảm</h5>
                {{-- Giả định discount_amount là giá trị giảm cố định --}}
                <p class="card-text fs-3 fw-bold">{{ number_format($totalUsageCount * $voucher->discount_amount) }} VNĐ</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h5 class="mb-0">Danh Sách Các Đơn Hàng Đã Sử Dụng</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Tên User (Đã Đăng nhập)</th>
                        <th>Tên Khách Hàng</th>
                        <th>Tổng Đơn Hàng</th>
                        <th>Thời Gian Dùng</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usedOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>
                            @if ($order->user)
                            {{ $order->user->name }} (ID: {{ $order->user->id }})
                            @else
                            Khách vãng lai
                            @endif
                        </td>
                        <td>{{ $order->customer_name ?? 'N/A' }}</td>
                        <td>{{ number_format($order->total) }} VNĐ</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Chưa có đơn hàng nào sử dụng mã giảm giá này.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $usedOrders->links() }}
    </div>
</div>

@endsection