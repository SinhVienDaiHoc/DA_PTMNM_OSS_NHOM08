@extends('admin.adminview')

@section('title', 'Tạo Mã Giảm Giá Mới')
@section('page_title', 'Tạo Mã Giảm Giá')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        {{-- HIỂN THỊ LỖI VALIDATION --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            Vui lòng kiểm tra lại các lỗi sau:
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.voucher.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- CỘT TRÁI: THÔNG TIN CƠ BẢN --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Mã Giảm Giá</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Mã Voucher (Code)</label>
                        <input type="text" class="form-control" id="code" name="code"
                            value="{{ old('code') }}" placeholder="VD: TET2025" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                            value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Kích hoạt (Cho phép sử dụng)</label>
                    </div>

                    <h6 class="mt-4 text-primary">Yêu cầu và Số lượng</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="required_points" class="form-label">Điểm cần để đổi (Points)</label>
                            <input type="number" class="form-control" id="required_points" name="required_points"
                                value="{{ old('required_points', 0) }}" min="0">
                            <small class="text-muted">Đặt 0 nếu không yêu cầu đổi điểm.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">Số lượng phát hành</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ old('quantity') }}" placeholder="Để trống nếu không giới hạn">
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: THÔNG TIN GIẢM GIÁ VÀ THỜI GIAN --}}
                <div class="col-md-6">
                    <h6 class="text-primary">Giá trị Voucher</h6>
                    <div class="mb-3">
                        <label for="type" class="form-label">Loại Giảm Giá</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">-- Chọn loại --</option>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Giảm giá cố định (VNĐ)</option>
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                            <option value="gift" {{ old('type') == 'gift' ? 'selected' : '' }}>Đổi quà tặng</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="discount_amount" class="form-label">Giá trị Giảm/Quà tặng ID</label>
                        <input type="number" class="form-control" id="discount_amount" name="discount_amount"
                            value="{{ old('discount_amount') }}" min="0" required>
                        <small class="text-muted">Nhập giá trị tiền hoặc % (hoặc ID quà tặng nếu chọn loại "gift").</small>
                    </div>


                    <h6 class="mt-4 text-primary">Thời gian hiệu lực</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_at" class="form-label">Bắt đầu từ</label>
                            {{-- Sử dụng Carbon để định dạng chuẩn HTML input type datetime-local --}}
                            <input type="datetime-local" class="form-control" id="start_at" name="start_at"
                                value="{{ old('start_at', now()->format('Y-m-d\TH:i')) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expires_at" class="form-label">Hết hạn vào</label>
                            <input type="datetime-local" class="form-control" id="expires_at" name="expires_at"
                                value="{{ old('expires_at') }}" required>
                        </div>
                    </div>

                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.voucher.index') }}" class="btn btn-secondary me-2">Quay lại</a>
                <button type="submit" class="btn btn-success">Tạo Voucher</button>
            </div>
        </form>
    </div>
</div>
@endsection