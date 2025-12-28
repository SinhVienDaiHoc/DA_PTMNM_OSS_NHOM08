@extends('layouts.app')

@section('title', 'Đổi Thưởng Voucher')

@section('content')
<div class="container container-wide my-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center text-primary fw-bold">🎁 Kho Voucher Đổi Thưởng 🎁</h1>
            <p class="text-center text-muted">Dùng điểm tích lũy của bạn để đổi lấy các mã giảm giá hấp dẫn!</p>
        </div>
    </div>
    
    <div class="row mb-5 justify-content-center">
        <div class="col-md-6">
            <div class="alert alert-warning text-center fw-bold">
                <i class="bi bi-wallet2 me-2"></i> Điểm hiện có của bạn: <span class="fs-4 text-dark">{{ number_format($userPoints) }} điểm</span>
            </div>
        </div>
    </div>

    {{-- Hiển thị thông báo (nếu có) --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        
        @forelse($vouchers as $voucher)
        @php
            $canExchange = $userPoints >= $voucher->required_points;
        @endphp
        
        <div class="col">
            <div class="card h-100 shadow-sm border-0 {{ $canExchange ? '' : 'bg-light text-muted' }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-success fw-bold">
                        @if($voucher->type === 'percentage')
                            {{ $voucher->discount_amount }}% GIẢM
                        @elseif($voucher->type === 'fixed')
                            GIẢM {{ number_format($voucher->discount_amount) }} VNĐ
                        @else
                            {{ $voucher->name }}
                        @endif
                    </h5>
                    <p class="card-text small text-truncate">{{ $voucher->description ?? 'Mã giảm giá áp dụng cho mọi đơn hàng.' }}</p>

                    <div class="mt-auto pt-3 border-top">
                        <p class="mb-2">
                            Yêu cầu đơn hàng tối thiểu: <span class="fw-bold">{{ number_format($voucher->min_order_amount) }} VNĐ</span>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-5 fw-bold {{ $canExchange ? 'text-danger' : 'text-secondary' }}">
                                <i class="bi bi-star-fill text-warning me-1"></i> {{ number_format($voucher->required_points) }} điểm
                            </span>
                            
                            <form action="{{ route('voucher.exchange.exchange', $voucher) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $canExchange ? 'btn-success' : 'btn-outline-secondary' }}" 
                                    {{ $canExchange ? '' : 'disabled' }}
                                    onclick="return confirm('Bạn có chắc chắn muốn đổi {{ number_format($voucher->required_points) }} điểm lấy mã này không?');"
                                >
                                    {{ $canExchange ? 'Đổi Ngay' : 'Không đủ điểm' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                {{-- Hiển thị mã đã hết lượt dùng --}}
                @if($voucher->quantity !== null && $voucher->orders()->count() >= $voucher->quantity)
                <div class="ribbon-wrapper">
                    <div class="ribbon bg-danger">Hết Lượt Đổi</div>
                </div>
                @endif
                
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">Hiện chưa có Voucher nào để đổi thưởng.</div>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Thêm CSS cho Ribbon (Dùng để hiển thị trạng thái Hết lượt đổi) */
    .ribbon-wrapper {
        overflow: hidden;
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        pointer-events: none;
    }
    .ribbon {
        font-size: 10px;
        color: #fff;
        text-align: center;
        transform: rotate(45deg);
        position: relative;
        padding: 5px 0;
        left: 20px;
        top: 30px;
        width: 200px;
        box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }
</style>

@endsection