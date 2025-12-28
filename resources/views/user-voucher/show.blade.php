@extends('layouts.app') 
{{-- Đảm bảo bạn đang sử dụng layout chính xác của ứng dụng --}}

@section('title', 'Chi tiết Voucher đã đổi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Đổi Voucher Thành Công! 🎉</h4>
                </div>
                <div class="card-body">
                    
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h5 class="card-title text-primary">{{ $userVoucher->voucher->name }}</h5>
                    <p class="card-text">Chúc mừng bạn đã đổi điểm thành công! Vui lòng lưu lại mã voucher này.</p>
                    
                    <hr>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <strong>Mã Voucher Của Bạn:</strong>
                            <h3 class="text-danger font-weight-bold p-2 border border-danger rounded mt-1">{{ $userVoucher->code }}</h3>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>Giá trị/Mô tả:</strong>
                            <p>{{ $userVoucher->voucher->description ?? 'Không có mô tả' }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Điểm đã dùng:</strong>
                            <p>{{ number_format($userVoucher->voucher->required_points) }} điểm</p>
                        </div>
                        <div class="col-sm-6">
                            <strong>Thời gian đổi:</strong>
                            <p>{{ $userVoucher->created_at->format('H:i:s d/m/Y') }}</p>
                        </div>
                    </div>

                    <hr>
                    
                    <a href="{{ route('home') }}" class="btn btn-secondary">Quay lại Trang chủ</a>
                    <a href="{{ url('/my-vouchers') }}" class="btn btn-primary">Xem Lịch sử Voucher</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection