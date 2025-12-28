@extends('admin.adminview')

@section('title', 'Quản lý sản phẩm')
@section('page_title', 'Danh sách Sản phẩm')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">


        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h5 class="card-title text-uppercase text-muted">Dữ liệu kho bánh</h5>

            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                + Thêm sản phẩm
            </a>
        </div>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên bánh</th>
                    <th>Danh mục</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Điểm thưởng</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @foreach($products as $sp)
                <tr>
                    <td>#{{ $sp->id }}</td>
                    <td>

                        <img src="{{ asset('uploads/products/'.$sp->image_cover) }}"
                            width="50" height="50" style="object-fit: cover; border-radius: 8px;">
                    </td>
                    <td class="fw-bold">{{ $sp->name }}</td>
                    <td>
                        <span class="badge bg-info text-dark">{{ $sp->category->name ?? '---' }}</span>
                    </td>
                    <td class="text-danger fw-bold">{{ number_format($sp->price) }}đ</td>
                    <td>
                        @if($sp->stock > 0)
                        <span class="badge bg-success">{{ $sp->stock }}</span>
                        @else
                        <span class="badge bg-secondary">Hết hàng</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $sp->reward_point }}</td>
                    <td class="text-end">

                        <a href="{{ route('admin.product.edit', $sp->id) }}" class="btn btn-sm btn-outline-primary" title="Sửa">
                            ✏️
                        </a>


                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $sp->id }}" title="Xóa">
                            🗑️
                        </button>

                        <div class="modal fade" id="deleteModal{{ $sp->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-4">

                                        <div class="text-danger mb-3" style="font-size: 3rem;">
                                            ⚠️
                                        </div>

                                        <h4 class="mb-2 fw-bold text-danger">Xác nhận xóa?</h4>
                                        <p class="text-muted mb-4">
                                            Bạn có chắc chắn muốn xóa sản phẩm <strong>"{{ $sp->name }}"</strong> không?<br>
                                            Hành động này không thể hoàn tác.
                                        </p>

                                        <div class="d-flex justify-content-center gap-2">

                                            <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">
                                                Hủy
                                            </button>


                                            <form action="{{ route('admin.product.destroy', $sp->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4">
                                                    Xóa ngay
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection