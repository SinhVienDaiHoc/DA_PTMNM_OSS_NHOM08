@extends('admin.adminview')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-dark fw-bold">✨ Thêm sản phẩm mới</h5>
            <a href="{{ route('admin.product.qlysanpham') }}" class="text-decoration-none text-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card-body p-4">

            {{-- Hiển thị thông báo thành công --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Hiển thị lỗi validate --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên bánh..." required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control" placeholder="0" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Số lượng kho</label>
                        <input type="number" name="stock" class="form-control" placeholder="0" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">Điểm thưởng</label>
                        <input type="number" name="reward_point" class="form-control" placeholder="0" value="0">
                        <small class="text-muted">Điểm tặng cho khách khi mua</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Danh mục</label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $cate)
                        <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Hình ảnh</label>
                    <input type="file" name="image_cover" class="form-control" required>
                    <small class="text-muted">Chấp nhận file: jpg, png, jpeg</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Mô tả chi tiết</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Nhập mô tả sản phẩm..."></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                        Thêm mới ngay
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection