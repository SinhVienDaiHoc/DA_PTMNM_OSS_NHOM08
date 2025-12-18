@extends('admin.adminview')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chi Tiết Người Dùng: {{ $user->name }}</h2>
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Quay lại DS User</a>
    </div>

    <div class="row">
        
        {{--  THÔNG TIN CƠ BẢN & ĐIỂM THƯỞNG --}}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Thông tin tài khoản
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $user->id }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Trạng thái Admin:</strong> 
                        @if ($user->is_admin)
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-success">Customer</span>
                        @endif
                    </p>
                    
                    <hr>
                    
                    <h4>Điểm Thưởng Hiện Tại</h4>
                    <p class="h3 text-info">
                        {{ number_format($currentPoints) }} điểm
                    </p>
                </div>
            </div>
            
            {{-- THÔNG TIN PROFILE (Nếu có) --}}
            <div class="card">
                <div class="card-header">Thông tin Cá nhân</div>
                <div class="card-body">
                    @if ($user->profile)
                        <p><strong>Điện thoại:</strong> {{ $user->profile->phone ?? 'N/A' }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $user->profile->address ?? 'N/A' }}</p>
                        <p><strong>Ngày sinh:</strong> {{ $user->profile->birthday ?? 'N/A' }}</p>
                    @else
                        <p class="text-muted">Chưa cập nhật thông tin cá nhân.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- COL 2: LỊCH SỬ MUA HÀNG & VOUCHER --}}
        <div class="col-md-8">
            
            {{-- LỊCH SỬ MUA HÀNG GẦN NHẤT --}}
            <div class="card mb-4">
                <div class="card-header">Lịch sử Mua hàng Gần nhất (10 đơn)</div>
                <div class="card-body">
                    @if ($user->orders->count() > 0)
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Ngày</th>
                                    <th class="text-end">Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->orders as $order)
                                <tr>
                                    <td><a href="{{ url('admin/orders', $order->id) }}">#{{ $order->id }}</a></td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="text-end">{{ number_format($order->total_amount) }} VND</td>
                                    <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Người dùng này chưa có đơn hàng nào.</p>
                    @endif
                </div>
            </div>

            {{-- VOUCHER ĐÃ ĐỔI --}}
            <div class="card">
                <div class="card-header">Voucher Đã Đổi</div>
                <div class="card-body">
                    @if ($user->usedVouchers->count() > 0)
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Voucher</th>
                                    <th>Mã Code</th>
                                    <th>Điểm Dùng</th>
                                    <th>Ngày Đổi</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->usedVouchers as $userVoucher)
                                <tr>
                                    <td>{{ $userVoucher->voucher->name ?? 'N/A' }}</td>
                                    <td><strong>{{ $userVoucher->code }}</strong></td>
                                    <td>{{ number_format($userVoucher->pointsRedemption->points_used ?? 0) }}</td>
                                    <td>{{ $userVoucher->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($userVoucher->used_at)
                                            <span class="badge bg-danger">Đã dùng</span>
                                        @else
                                            <span class="badge bg-success">Chưa dùng</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Người dùng này chưa đổi voucher nào.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection