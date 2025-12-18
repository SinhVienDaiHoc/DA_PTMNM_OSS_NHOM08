@extends('layouts.app')

@section('title', 'Cập Nhật Hồ Sơ Khách Hàng')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            {{-- THẺ CHỨA FORM THÔNG TIN CÁ NHÂN --}}
            <div class="card shadow-lg border-0 rounded-4" style="border-top: 5px solid #E9967A;">
                <div class="card-header bg-white text-center pt-4">
                    <h4 class="mb-0 fw-bold" style="color: #4A1F1B;">🍰 Hồ Sơ Khách Hàng</h4>
                    <p class="text-muted small">Cập nhật thông tin để việc đặt hàng thuận tiện hơn.</p>
                </div>
                <div class="card-body p-4">
                    
                    {{-- THÔNG BÁO CẬP NHẬT PROFILE THÀNH CÔNG --}}
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT') 
                        
                        {{-- 1. Họ và Tên đầy đủ --}}
                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-bold">Họ và Tên đầy đủ <span class="text-danger">*</span></label>
                            <input id="full_name" type="text" 
                                   name="full_name" 
                                   class="form-control form-control-lg @error('full_name') is-invalid @enderror"
                                   value="{{ old('full_name', $user->profile->full_name ?? '') }}" 
                                   required 
                                   style="border-color: #E9967A;">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- 2. Số điện thoại --}}
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label fw-bold">Số điện thoại</label>
                                <input id="phone_number" type="text" 
                                       name="phone_number" 
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       value="{{ old('phone_number', $user->profile->phone_number ?? '') }}"
                                       placeholder="VD: 090xxxxxxx" style="border-color: #E9967A;">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 3. Ngày sinh (ĐÃ BỔ SUNG LẠI) --}}
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label fw-bold">Ngày sinh</label>
                                <input id="date_of_birth" type="date" 
                                       name="date_of_birth" 
                                       class="form-control @error('date_of_birth') is-invalid @enderror"
                                       value="{{ old('date_of_birth', $user->profile->date_of_birth ?? '') }}"
                                       style="border-color: #E9967A;">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- 4. GIỚI TÍNH --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Giới tính</label>
                            @php $gender = old('gender', $user->profile->gender ?? ''); @endphp
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" {{ $gender == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="genderMale">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" {{ $gender == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="genderFemale">Nữ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other" {{ $gender == 'other' ? 'checked' : '' }}>
                                <label class="form-check-label" for="genderOther">Khác</label>
                            </div>
                            @error('gender')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 5. ĐỊA CHỈ GIAO HÀNG --}}
                        <div class="mb-4">
                            <label for="address" class="form-label fw-bold">Địa chỉ giao hàng mặc định</label>
                            <textarea id="address" name="address" rows="3"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Địa chỉ chi tiết"
                                      style="border-color: #E9967A;">{{ old('address', $user->profile->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Nút Lưu --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg fw-bold text-white" 
                                    style="background-color: #E9967A; border-color: #E9967A;">
                                Lưu lại thông tin
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div> 
    
    {{-- PHẦN THAY ĐỔI MẬT KHẨU (Collapse) --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-8 col-lg-7">
            
            {{-- START COLLAPSE --}}
            <button class="btn btn-block w-100 p-3 shadow-lg border-0 fw-bold d-flex justify-content-between align-items-center"
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapsePassword" 
                    aria-expanded="false" 
                    aria-controls="collapsePassword"
                    style="background-color: #FFE4B5; color: #4A1F1B;">
                <span>🔒 Thay Đổi Mật Khẩu</span>
                <i class="bi bi-chevron-down"></i> 
            </button>

            {{-- NỘI DUNG FORM SẼ BỊ ẨN --}}
            <div class="collapse 
                 @if ($errors->has('current_password') || $errors->has('password') || session('password_success')) show @endif" 
                 id="collapsePassword">
                
                <div class="card card-body rounded-top-0 shadow-lg border-top-0 p-4">
                    
                    {{-- THÔNG BÁO MẬT KHẨU THÀNH CÔNG --}}
                    @if (session('password_success'))
                        <div class="alert alert-success text-center">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('password_success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT') 

                        {{-- Mật khẩu hiện tại --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                            <input id="current_password" type="password" 
                                   name="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   required autocomplete="current-password"
                                   style="border-color: #E9967A;">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mật khẩu mới --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Mật khẩu mới <span class="text-danger">*</span></label>
                            <input id="password" type="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   required autocomplete="new-password"
                                   style="border-color: #E9967A;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Xác nhận mật khẩu mới --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                            <input id="password_confirmation" type="password" 
                                   name="password_confirmation" 
                                   class="form-control"
                                   required autocomplete="new-password"
                                   style="border-color: #E9967A;">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg fw-bold text-white" 
                                    style="background-color: #E9967A; border-color: #E9967A;">
                                Đổi Mật Khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END THAY ĐỔI MẬT KHẨU (Collapse) --}}

</div>
@endsection