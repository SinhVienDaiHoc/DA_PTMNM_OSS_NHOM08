@extends('admin.adminview')

@section('title', 'Quản Lý Mã Giảm Giá')
@section('page_title', 'Danh Sách Mã Giảm Giá')

@section('content')

{{-- HIỂN THỊ THÔNG BÁO TỪ SESSION (Đã thêm vào Layout chính) --}}
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Tổng cộng: {{ $vouchers->total() }} mã</h4>
        <a href="{{ route('admin.voucher.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tạo Voucher Mới
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã Code</th>
                        <th>Tên Mã</th>
                        <th>Giá Trị</th>
                        <th>Đơn T.Thiểu</th>
                        <th>Lượt Dùng</th>
                        <th>Hạn Dùng</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->id }}</td>
                        <td class="fw-bold text-primary">{{ $voucher->code }}</td>
                        <td>{{ $voucher->name }}</td>
                        <td>
                            @if ($voucher->type === 'percentage')
                            {{ $voucher->discount_amount }}%
                            @else
                            {{ number_format($voucher->discount_amount) }} VNĐ
                            @endif
                        </td>
                        <td>{{ number_format($voucher->min_order_amount) }} VNĐ</td>
                        {{-- Sử dụng orders_count đã được load từ Controller (Voucher::withCount('orders')) --}}
                        <td>{{ $voucher->orders_count ?? 0 }} / {{ $voucher->quantity ?? '∞' }}</td>
                        <td>{{ optional($voucher->expires_at)->format('d/m/Y') }}</td>
                        <td>
                            @php
                            $isActive = $voucher->is_active && ($voucher->expires_at === null || $voucher->expires_at > now());
                            // Kiểm tra thêm số lượng nếu có giới hạn
                            if ($voucher->quantity !== null && $voucher->orders_count >= $voucher->quantity) {
                            $isActive = false;
                            }
                            @endphp
                            <span class="badge bg-{{ $isActive ? 'success' : 'danger' }}">
                                {{ $isActive ? 'Hoạt động' : 'Hết hạn/Hết lượt' }}
                            </span>
                        </td>
                        <td>
                            {{-- NÚT XEM THỐNG KÊ (Đáp ứng yêu cầu của bạn) --}}
                            <a href="{{ route('admin.voucher.stats', $voucher) }}" class="btn btn-sm btn-warning me-1" title="Thống kê chi tiết User đã sử dụng">
                                <i class="fas fa-chart-bar"></i> Thống kê
                            </a>

                            {{-- NÚT SỬA (Edit) --}}
                            <a href="{{ route('admin.voucher.edit', $voucher) }}" class="btn btn-sm btn-primary" title="Sửa Voucher">
                                <i class="fas fa-edit"></i> Sửa
                            </a>

                            {{-- FORM XÓA (DELETE) --}}
                            <form action="{{ route('admin.voucher.destroy', $voucher) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá {{ $voucher->code }}? Hành động này không thể hoàn tác nếu mã đã được sử dụng.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa Voucher">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $vouchers->links() }}
    </div>
</div>
@endsection