@extends('layouts.app')

@section('title', 'Tìm kiếm')

@section('content')
<div class="py-4" style="background:#fbf1e0;">
  <div class="container container-wide">

    <h3 class="mb-3 fw-bold">
      Kết quả tìm kiếm: "{{ $keyword }}"
    </h3>

    @if ($products->isEmpty())
    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm mt-2">
      ← Quay lại trang chủ
    </a>
    @else
    <p class="text-muted small mb-3">
      Tìm thấy {{ $products->count() }} sản phẩm.
    </p>

    <div class="row g-4">
      @foreach ($products as $product)
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm">
          <div class="ratio ratio-1x1">
            <a href="{{ route('product.detail', $product->id) }}">
              <img src="{{ asset('uploads/products/' . $product->image_cover) }}"
                class="card-img-top"
                alt="{{ $product->name }}"
                style="object-fit:cover;">
            </a>
          </div>

          <div class="card-body p-0">

            {{-- Giá + nút giỏ --}}
            <div class="d-flex">
              <div class="flex-grow-1 px-3 py-2"
                style="background:#c7d600;color:#fff;font-weight:700;">
                {{ number_format($product['price']) }} đ
              </div>

              <form action="{{ route('cart.add', $product['id']) }}" method="POST" class="m-0">
                @csrf
                <input type="hidden" name="id" value="{{ $product['id'] }}">
                <input type="hidden" name="name" value="{{ $product['name'] }}">
                <input type="hidden" name="price" value="{{ $product['price'] }}">
                <input type="hidden" name="image" value="{{ $product['image'] }}">

                <button type="submit"
                  class="btn px-3 py-2 h-100"
                  style="background:#4a1f1b;color:#fff;border-radius:0;">
                  <i class="bi bi-cart"></i>
                </button>
              </form>
            </div>

            <div class="px-3 py-3">
              <div class="fw-bold text-uppercase small">
                {{ $product['name'] }}
              </div>

              @if(!empty($product['tag']))
              <div class="mt-1 small text-muted">
                {{ $product['tag'] }}
              </div>
              @endif
            </div>
          </div>

        </div>
      </div>
      @endforeach
    </div>
    @endif

  </div>
</div>
@endsection