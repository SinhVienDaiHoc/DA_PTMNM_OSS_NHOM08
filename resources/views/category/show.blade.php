@extends('layouts.app')
@section('title', $category->name)
@section('content')

<div class="py-4" style="background:#f9f1e3;">
    <div class="container container-wide">
        <h3 class="mb-4 fw-bold">{{ $category->name }}</h3>
        <div class="row g-4">
            @if($products->isEmpty())
            <div class="col-12 text-center">
                <p>Chưa có sản phẩm nào trong danh mục này.</p>
            </div>
            @else
            @foreach ($products as $product)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="ratio ratio-1x1">
                        <a href="{{ route('product.detail', $product->id) }}">
                            <img src="{{ asset('uploads/products/'.$product->image_cover) }}"
                                class="card-img-top"
                                alt="{{ $product->name }}"
                                style="object-fit:cover;">
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="d-flex">
                            <div class="flex-grow-1 px-3 py-2" style="background:#c7d600;color:#fff;font-weight:700;">
                                {{ number_format($product->price) }} đ
                            </div>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <button type="submit" class="btn px-3 py-2 h-100" style="background:#4a1f1b;color:#fff;border-radius:0;">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </form>
                        </div>
                        <div class="px-3 py-3">
                            <div class="fw-bold text-uppercase small">
                                {{ $product->name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection