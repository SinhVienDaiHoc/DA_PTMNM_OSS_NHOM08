@extends('admin.adminview')

@section('title', 'Quản lý Danh mục')
@section('page_title', 'Quản lý Danh mục')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h5 class="card-title text-uppercase text-muted">Danh sách loại bánh</h5>
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                + Thêm danh mục
            </a>
        </div>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug (Đường dẫn)</th>
                    <th>Mô tả</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cate)
                <tr>
                    <td>{{ $cate->id }}</td>
                    <td class="fw-bold text-primary">{{ $cate->name }}</td>
                    <td><code>{{ $cate->slug }}</code></td>
                    <td>{{ $cate->description }}</td>
                    <td class="text-end">

                        <a href="{{ route('admin.category.edit', $cate->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Sửa">
                            ✏️ Sửa
                        </a>

                        {{--LOGIC--}}
                        @if($cate->products_count > 0)

                        {{-- TRƯỜNG HỢP 1 --}}
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-toggle="modal" data-bs-target="#warningModal{{ $cate->id }}" title="Không thể xóa">
                            🚫 Xóa
                        </button>

                        <div class="modal fade" id="warningModal{{ $cate->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-4">
                                        <div class="text-warning mb-3" style="font-size: 3rem;">🛑</div>
                                        <h4 class="mb-2 fw-bold text-dark">Không thể xóa!</h4>
                                        <p class="text-muted">
                                            Danh mục <strong>"{{ $cate->name }}"</strong> đang chứa
                                            <span class="fw-bold text-danger">{{ $cate->products_count }} sản phẩm</span>.
                                        </p>
                                        <p class="small text-muted mb-4">
                                            Bạn cần xóa hoặc chuyển hết sản phẩm sang danh mục khác trước khi xóa danh mục này.
                                        </p>
                                        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Đã hiểu</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @else

                        {{-- TRƯỜNG HỢP 2:--}}
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $cate->id }}" title="Xóa">
                            🗑️ Xóa
                        </button>

                        <div class="modal fade" id="deleteModal{{ $cate->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-4">
                                        <div class="text-danger mb-3" style="font-size: 3rem;">⚠️</div>
                                        <h4 class="mb-2 fw-bold text-danger">Xác nhận xóa?</h4>
                                        <p class="text-muted mb-4">
                                            Bạn có chắc muốn xóa danh mục <strong>"{{ $cate->name }}"</strong>?<br>
                                            Hành động này không thể hoàn tác.
                                        </p>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('admin.category.destroy', $cate->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4">Xóa ngay</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">{{ $categories->links() }}</div>
    </div>
</div>
@endsection