@extends('admin.adminview')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">✨ Thêm danh mục mới</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên danh mục</label>
                    <input type="text" name="name" class="form-control" placeholder="Ví dụ: Bánh Mì Pháp..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả ngắn</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu danh mục</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection