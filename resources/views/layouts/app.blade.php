<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale() ) }}">

<head>

  <meta charset="utf-8">
  <title>STU Bakery</title>

  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') | {{ config('app.name') }}</title>

  {{-- Bootstrap + Icons (CDN) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    .container-wide {
      max-width: 1200px
    }

    .topbar {
      background: #F8EEDB;
      box-shadow: 0 6px 14px rgba(0, 0, 0, .04)
    }

    .brand {
      font-weight: 800;
      color: #ffb000
    }

    .search-input {
      border-radius: 999px;
      background: #f6f7fb
    }

    .category-btn {
      border-radius: 12px;
      background: #f4f6f8
    }

    /* fix selector: phải có khoảng trắng giữa .hero và .carousel-item */
    .hero .carousel-item img {
      width: 100%;
      height: 420px;
      object-fit: cover;
      border-radius: 16px
    }

    .badge-dot {
      position: absolute;
      top: 0;
      right: 0;
      transform: translate(30%, -30%)
    }

    @media (max-width:576px) {
      .hero .carousel-item img {
        height: 240px
      }
    }
  </style>

  @stack('head')
</head>

<body class="site-background">


  <header class="topbar custom-header {{ request()->routeIs('home') ? 'sticky-top' : '' }}">

    <div class="container container-wide py-2">
      <div class="d-flex align-items-center gap-3">

        {{-- start Logo --}}
        <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center gap-2">
          <span class="brand fs-4">STU Bakery</span>
        </a>
        {{-- end Logo --}}

        {{-- start Tìm kiếm desktop --}}
        {{-- {{ route('search') }} thay vao action --}}
        <form action="" method="GET" class="flex-grow-1 d-none d-md-block">
          <div class="input-group">
            <input class="form-control search-input px-4"
              type="search"
              name="q"
              placeholder="Tìm kiếm tên bánh...">
            <button class="btn search-btn px-3 rounded-end-pill" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
        {{-- end Tìm kiếm desktop --}}

        {{-- start Icon phải --}}
        <div class="ms-auto d-flex align-items-center gap-3">

          {{-- GIỎ HÀNG --}}
          <a href="#">Giỏ hàng</a>
          {{-- <a href="{{ route('cart.index') }}" class="position-relative text-dark text-decoration-none">
            <i class="bi bi-cart3 fs-4"></i>
            @php
            $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
            @endphp

            <span class="badge bg-danger rounded-pill badge-dot">
              {{ $cartCount }}
            </span>

            <span class="ms-1 d-none d-lg-inline">Giỏ hàng</span>
          </a> --}}

          <div class="dropdown">
            <a href="#" class="text-dark text-decoration-none dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle fs-4"></i>
              <span class="d-none d-lg-inline">
                @auth
                {{ Auth::user()->name }}
                @else
                Tài khoản
                @endauth
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">

              @guest
              {{-- Khi CHƯA đăng nhập --}}
              <li>
                <a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('register') }}">Đăng ký</a>
              </li>
              @endguest

              @auth
              {{-- Khi ĐÃ đăng nhập --}}
              <li class="dropdown-item text-dark fw-bold d-flex align-items-center gap-2">
                👤 {{ Auth::user()->name }}
                <span class="badge bg-warning text-dark">
        @php
            $points = \Illuminate\Support\Facades\DB::table('points')
                ->where('user_id', Auth::id())
                ->sum('points');
        @endphp
        {{ $points }} điểm
    </span>
</li>

              <li><a class="dropdown-item" href="{{ url('/profile') }}">Hồ sơ</a></li>
              <li><a class="dropdown-item" href="{{ url('/don-hang') }}">Đơn hàng</a></li>

              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button class="dropdown-item text-danger" type="submit">
                    Đăng xuất
                  </button>
                </form>
              </li>
              @endauth

            </ul>
          </div>
          {{-- end Icon phải --}}

          {{-- start Nút search mobile --}}
          <button class="btn d-md-none" data-bs-toggle="collapse" data-bs-target="#mSearch">
            <i class="bi bi-search fs-5"></i>
          </button>
        </div>
      </div>
      {{-- end Nút search mobile --}}

      {{-- start Ô tìm kiếm mobile --}}
      <div id="mSearch" class="collapse mt-2 d-md-none">
        {{-- {{ route('search') }} --}}
        <form action="" method="GET">
          <div class="input-group">
            <input class="form-control search-input px-4"
              type="search"
              name="q"
              value="{{ request('q') }}"
              placeholder="Tìm kiếm tên bánh...">
            <button class="btn btn-outline-secondary px-3 rounded-end-pill" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
      {{-- end Ô tìm kiếm mobile --}}

      {{-- start Nút Danh mục --}}
      <div class="mt-3">
        <button class="btn category-btn px-3 py-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCategories">
          <i class="bi bi-list me-2"></i> Danh mục
        </button>
      </div>
      {{-- end Nút Danh mục --}}

    </div>
  </header>

  {{-- start Offcanvas Danh mục --}}
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasCategories">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Danh mục</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body small">
      <ul class="list-unstyled">
        {{-- Chính sách --}}
        <li><a class="dropdown-item py-2" href="{{ route('chinhsachchung') }}">Các chính sách của cửa hàng</a></li>

        {{-- List đổi thưởng --}}
        {{-- {{ route('voucher.exchange.index') }} --}}
        <li><a class="dropdown-item fw-bold text-success" href="">
                <i class="bi bi-gift"></i> Đổi thưởng Voucher
             </a></li>

        {{-- Túi chứa voucher --}}

        <li class="nav-item">
          {{-- {{ route('user-voucher.index') }} --}}
    <a href="" class="nav-link">
        <i class="fas fa-ticket-alt"></i>
        <p>Túi Voucher Của Tôi</p>
    </a>
</li>

        @foreach($globalCategories as $cate)
        <li>
          {{-- {{ route('category.show', $cate->id) }} --}}
          <a class="dropdown-item py-2" href="">
            {{ $cate->name }}
          </a>
        </li>
        @endforeach

      </ul>
    </div>
  </div>
  {{-- end Offcanvas Danh mục --}}

  {{-- start Layout main body --}}
  <main>@yield('content')</main>
  {{-- end Layout main body --}}

  {{-- start footer --}}
  <footer class="mt-5 py-4 footer-background">
    <div class="container container-wide text-center small text-muted">
      © {{ date('Y') }} Stu-DoAn
    </div>
  </footer>
  {{-- end footer --}}

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>


@if (session('cart_success'))
<div id="toast-cart"
  style="
            position: fixed;
            top: 70px;            
            right: 200px;         
            background: #d4f4dd;
            color: #155724;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
            font-weight: 600;
            z-index: 9999;
            transition: all 0.4s;
        ">
  {{ session('cart_success') }}
</div>

<script>
  setTimeout(() => {
    const t = document.getElementById('toast-cart');
    if (t) {
      t.style.opacity = '0';
      setTimeout(() => t.remove(), 400);
    }
  }, 2000);
</script>
@endif


</html>