@extends('layouts.app')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4"> {{-- Rounded-4 cho góc bo tròn lớn hơn --}}
            
            {{-- Header Card với màu ấm (Coral/Orange) --}}
            <div class="card-header bg-coral text-white rounded-top-4">
                <h3 class="text-center font-weight-light my-4">Tạo Tài Khoản Mới</h3>
            </div>
            
            <div class="card-body p-4 p-md-5">
                @if(session('message'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                {{-- Form đăng kí --}}
                <form action="{{ route('postRegister') }}" method="POST" novalidate >
                    @csrf 
                    
                    {{-- Tên --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small">Họ và tên </label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}" 
                               class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror" placeholder="Tên đăng nhập">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small">Email</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" 
                               class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror" placeholder="Địa chỉ email ">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mật Khẩu --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold small">Mật Khẩu</label>
                        <input type="password" id="password" name="password" required 
                               class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Xác Nhận Mật Khẩu --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-bold small">Xác Nhận Mật Khẩu</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                               class="form-control form-control-lg rounded-3">
                        {{-- Laravel validation uses 'password' for password_confirmation errors --}}
                        @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nút Đăng Ký --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning btn-lg fw-bold rounded-3 text-white shadow-sm">Đăng Ký Tài Khoản</button>
                    </div>
                </form>
            </div>
            
            {{-- Footer Card --}}
            <div class="card-footer text-center py-3 bg-light rounded-bottom-4">
                <div class="small">
                    Đã có tài khoản? <a href="{{ route('login') ?? '#' }}" class="text-decoration-none fw-bold text-coral-dark">Đăng nhập ngay!</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Thêm CSS tùy chỉnh cho màu sắc --}}
<style>
    /* Định nghĩa màu sắc ấm áp cho website bán hàng */
    .bg-coral {
        background-color: #FF6B6B !important; /* Màu Coral tươi sáng */
    }
    .text-coral-dark {
        color: #CC5555 !important; /* Màu tối hơn cho link/text */
    }
    .btn-warning {
        /* Đổi màu btn-warning thành màu ấm của website */
        background-color: #FF9966 !important; /* Màu cam đào */
        border-color: #FF8855 !important;
    }
    .btn-warning:hover {
        background-color: #FF8855 !important;
    }
    .form-control:focus {
        border-color: #FF9966; /* Viền sáng màu cam khi focus */
        box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25); /* Shadow nhẹ nhàng */
    }
</style>
@endsection