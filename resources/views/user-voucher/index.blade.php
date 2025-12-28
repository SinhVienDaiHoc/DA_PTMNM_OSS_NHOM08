@extends('layouts.app') 

@section('title', 'Túi Voucher và Lịch sử Giao dịch')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Túi Voucher và Lịch sử Giao dịch Đổi điểm</h2>
    
    @forelse ($userVouchers as $item)
        {{-- $item là một bản ghi UserVoucher --}}
        <div class="card mb-3 shadow-sm @if(!$item->used_at) border-primary @else border-secondary @endif">
            <div class="card-body">
                <div class="row align-items-center">
                    
                    <div class="col-md-4">
                        <h5 class="card-title text-primary mb-1">{{ $item->voucher->name ?? 'Voucher (Không rõ tên)' }}</h5>
                        <p class="mb-0 text-muted small">
                            Đã đổi ngày: {{ $item->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    
                    <div class="col-md-3">
                        <p class="mb-1">
                            Mã Voucher: 
                            <strong class="text-danger">{{ $item->code }}</strong>
                        </p>
                        <p class="mb-0">
                            Trạng thái: 
                            @if ($item->used_at)
                                <span class="badge bg-secondary text-white">Đã sử dụng</span>
                            @else
                                <span class="badge bg-success text-white">Chưa dùng</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="col-md-3 text-start">
                        @php
                            // Lấy thông tin từ bảng PointsRedemption (chi tiết giao dịch)
                            $redemption = $item->pointsRedemption;
                        @endphp
                        <p class="mb-1">
                            Điểm đã dùng: 
                            <strong class="text-info">{{ number_format($redemption->points_used ?? 0) }} điểm</strong>
                        </p>
                        <p class="mb-0 text-muted small">
                             Trạng thái ghi nhận: {{ ($redemption->status ?? 0) == 1 ? 'Thành công' : 'Thất bại' }}
                        </p>
                    </div>

                    <div class="col-md-2 text-end">
                        <a href="{{ route('user.vouchers.show', $item->id) }}" class="btn btn-sm btn-outline-info">
                            Xem Chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">
            Bạn chưa đổi voucher nào. Hãy đổi điểm ngay!
        </div>
    @endforelse
</div>
@endsection