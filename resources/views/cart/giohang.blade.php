@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 fw-bold text-uppercase border-bottom pb-2">Giỏ hàng của bạn</h3>

    {{-- THÔNG BÁO --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    @if (empty($cart) || count($cart) == 0)
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <p class="mt-3 fs-5 text-muted">Giỏ hàng đang trống.</p>
        <a href="{{ route('home') }}" class="btn btn-warning text-white mt-2">
            <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
        </a>
    </div>
    @else
    @php $total = 0; @endphp
    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%">Sản phẩm</th>
                    <th style="width: 15%">Giá</th>
                    <th style="width: 15%">Số lượng</th>
                    <th style="width: 20%">Thành tiền</th>
                    <th style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $id => $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @if(!empty($item['image']))
                            <img src="{{ asset('uploads/products/' . $item['image']) }}"
                                alt="{{ $item['name'] }}"
                                class="rounded border me-3"
                                style="width: 70px; height: 70px; object-fit: cover;">
                            @endif
                            <div>
                                <div class="fw-bold">{{ $item['name'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="fw-bold text-secondary">{{ number_format($item['price']) }} đ</td>
                    <td>
                        {{-- Form cập nhật số lượng --}}
                        <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            {{-- Input ẩn chứa ID để controller biết đang sửa cái nào --}}
                            <input type="hidden" name="id" value="{{ $id }}">

                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                class="form-control form-control-sm text-center border-secondary"
                                style="width: 60px;">

                            <button class="btn btn-sm btn-light border ms-2" type="submit" title="Cập nhật">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </form>
                    </td>
                    <td class="fw-bold text-danger">
                        {{ number_format($item['price'] * $item['quantity']) }} đ
                    </td>
                    <td>
                        {{-- Form xóa --}}
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button class="btn btn-sm btn-outline-danger border-0" type="submit" title="Xóa">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end align-items-center mt-4 p-4 bg-light rounded shadow-sm">
        <div class="text-end me-4">
            <span class="text-muted">Tổng thanh toán:</span>
            <h3 class="fw-bold text-danger mb-0">{{ number_format($total) }} đ</h3>
        </div>
        <a href="{{ route('checkout.show') }}" class="btn btn-success btn-lg px-5 fw-bold shadow">
            Thanh toán <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    @endif
</div>
@endsection