@extends('admin.adminview')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-dark fw-bold">✏️ Cập nhật sản phẩm: {{ $product->name }}</h5>
            <a href="{{ route('admin.product.qlysanpham') }}" class="text-decoration-none text-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-bold">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">Số lượng kho</label>
                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">Điểm thưởng</label>
                        <input type="number" name="reward_point" class="form-control" value="{{ $product->reward_point }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Danh mục</label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $cate)
                        <option value="{{ $cate->id }}" {{ $product->category_id == $cate->id ? 'selected' : '' }}>
                            {{ $cate->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Hình ảnh hiện tại</label>
                    <div class="mb-2">
                        <img src="{{ asset('uploads/products/'.$product->image_cover) }}" width="100" class="rounded">
                    </div>
                    <label class="form-label text-muted small">Chọn ảnh mới (nếu muốn thay đổi)</label>
                    <input type="file" name="image_cover" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Mô tả chi tiết</label>
                    <textarea name="description" class="form-control" rows="5">{{ $product->description }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning px-4 py-2 fw-bold text-white">
                        Cập nhật ngay
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection