@extends('layouts.app')

@section('title', 'Thông tin thanh toán')

@section('content')
<div class="py-4" style="background:#fbf1e0;">
  <div class="container container-wide">

    <h3 class="mb-4 fw-bold">Thông tin thanh toán</h3>

    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- HIỂN THỊ THÀNH CÔNG (Ví dụ: áp dụng voucher thành công) --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    <form action="{{ route('checkout.process') }}" method="POST" class="mb-5">
        @csrf

        {{-- Họ và tên --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
            <input type="text"
                   name="customer_name"
                   class="form-control"
                   placeholder="Nhập họ và tên"
                   value="{{ old('customer_name',optional($profile)->full_name) }}">
        </div>

        {{-- Số điện thoại --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
            <input type="text"
                   name="customer_phone"
                   class="form-control"
                   placeholder="Nhập số điện thoại"
                   value="{{ old('customer_phone',optional($profile)->phone_number) }}">
        </div>

        {{-- Địa chỉ --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
            <textarea name="customer_address"
                      rows="3"
                      class="form-control"
                      placeholder="Nhập địa chỉ chi tiết">{{ old('customer_address',optional($profile)->address) }}</textarea>
        </div>

        {{-- Phương thức thanh toán --}}
        <div class="mb-3">
            <label class="form-label fw-semibold d-block">Phương thức thanh toán <span class="text-danger">*</span></label>

            <div class="form-check mb-1">
                <input class="form-check-input"
                       type="radio"
                       name="payment_method"
                       id="pm_bank"
                       value="bank_transfer"
                       {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                <label class="form-check-label" for="pm_bank">
                    Chuyển khoản
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input"
                       type="radio"
                       name="payment_method"
                       id="pm_cash"
                       value="cash"
                       {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                <label class="form-check-label" for="pm_cash">
                    Tiền mặt khi nhận hàng
                </label>
            </div>
        </div>

        {{-- Tổng tiền --}}
        <div class="mb-4">
            <span class="fw-semibold">Tổng cộng:</span>
            <span class="fw-bold">
                {{ number_format($total, 0, ',', '.') }} đ
            </span>
        </div>
        {{-- =================================== --}}
        <div class="mb-3">
    <label for="voucher_code" class="form-label">Mã Giảm Giá (Voucher)</label>
    <div class="input-group">
        <input type="text" class="form-control" id="voucher_code" name="voucher_code" placeholder="Nhập mã voucher...">
        </div>
</div>

        <button type="submit" class="btn btn-success px-4">
            Xác nhận đặt hàng
        </button>
    </form>

  </div>
</div>
@endsection
