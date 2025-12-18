
@extends('layouts.app') 

@section('content')

<style>
    /* Sử dụng lại style từ form đăng ký cho giao diện nhất quán */
    body {
        background: linear-gradient(135deg, #f0f4f8 0%, #e0e7ee 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-card {
        background-color: #ffffff;
        border-radius: 1rem; 
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 2.5rem; 
        transition: transform 0.3s ease-in-out;
    }
    .login-card:hover {
        transform: translateY(-5px);
    }
    .input-field {
        border: 1px solid #d1d5db; 
        border-radius: 0.5rem; 
        padding: 0.75rem 1rem; 
        width: 100%;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .input-field:focus {
        outline: none;
        border-color: #3b82f6; 
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); 
    }
    .submit-button {
        background-color: #3b82f6; 
        color: white;
        font-weight: 600; 
        padding: 0.8rem 1.5rem; 
        border-radius: 0.75rem; 
        transition: background-color 0.2s ease, transform 0.1s ease;
    }
    .submit-button:hover {
        background-color: #2563eb; 
        transform: translateY(-1px);
    }
    .submit-button:active {
        transform: translateY(0);
    }
    .error-message {
        color: #ef4444; 
        font-size: 0.875rem; 
        margin-top: 0.25rem; 
    }
</style>

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="login-card">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Đăng Nhập</h2>
            
            <!-- Hiển thị lỗi chung (nếu có) -->
            @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-6 shadow-sm">
                Thông tin đăng nhập không chính xác.
            </div>
            @endif

            <form action="{{ route('postLogin') }}" method="POST">
                @csrf 
                
                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" 
                           class="input-field" placeholder="example@email.com">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Mật khẩu</label>
                    <input type="password" id="password" name="password" required 
                           class="input-field" placeholder="••••••••">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Checkbox "Ghi nhớ" -->
                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Ghi nhớ đăng nhập
                    </label>
                </div>
                
                <button type="submit" class="submit-button w-full">Đăng Nhập</button>
            </form>

            <p>
               Chưa có tài khoản? 
                <a href="{{ route('register') }}">Đăng ký ngay</a>
            </p>

        </div>
    </div>
</div>


@endsection