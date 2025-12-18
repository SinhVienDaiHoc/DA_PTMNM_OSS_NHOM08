<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin') | STU Bakery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: hsl(238, 76%, 13%);
            --sidebar-bg-soft: #0f172a;
            --sidebar-text: #ebe5e5;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f3f4f6;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .admin-sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;

            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .admin-brand {
            height: 64px;
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(148, 163, 184, .35);
            display: flex;
            align-items: center;
        }

        .admin-brand-text {
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-size: .85rem;
        }

        .admin-nav {
            flex: 1;
            padding: 1.25rem .75rem;
        }

        .admin-nav-section-title {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9ca3af;
            margin-bottom: .5rem;
            padding: 0 .75rem;
        }

        .admin-nav-link {
            display: block;
            padding: .65rem 1.1rem;
            margin-bottom: .25rem;
            border-radius: .5rem;
            color: #e5e7eb;
            font-size: .9rem;
            text-decoration: none;
            transition: all .16s ease;
        }

        .admin-nav-link:hover {
            background: var(--sidebar-bg-soft);
            color: #fff;
        }

        .admin-sidebar-footer {
            padding: .9rem 1rem 1.2rem;
            border-top: 1px solid rgba(148, 163, 184, .35);
        }

        .admin-logout-btn {
            width: 100%;
            border-radius: .55rem;
            font-size: .85rem;
            font-weight: 600;
            padding: .45rem .75rem;
        }

        /* MAIN */
        .admin-main {
            flex: 1;
            background: #f3f4f6;
            display: flex;
            flex-direction: column;
            margin-left: 260px;
            min-height: 100vh;
        }

        .admin-topbar {
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
        }

        .admin-topbar-title {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .admin-content {
            flex: 1;
            padding: 1.5rem 1.75rem 2rem;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform .2s ease;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">

        {{-- SIDEBAR --}}
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-brand">
                <div class="admin-brand-text">ADMIN</div>
            </div>

            <nav class="admin-nav">
                <div class="admin-nav-section-title">Quản lý</div>
                <a href="#" class="admin-nav-link"> Dashboard</a>
                {{-- <a href="{{ route('admin.dashboard') }}"
                class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
                </a> --}}


                {{-- Sản phẩm --}}
                <a href="#" class="admin-nav-link">Quản lí sản phẩm</a>
                {{-- <a href="{{ route('admin.product.qlysanpham') }}"
                class="admin-nav-link {{ request()->routeIs('admin.product.qlysanpham') ? 'active' : '' }}">
                Quản lí sản phẩm
                </a> --}}

                {{-- Đơn hàng --}}
                <a href="#" class="admin-nav-link">Quản lí đơn hàng</a>
                {{-- <a href="{{ route('admin.orders.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                Quản lí đơn hàng
                </a> --}}

                {{-- Danh mục --}}
                <a href="#" class="admin-nav-link">Quản lí danh mục</a>
                {{-- <a href="{{ route('admin.category.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.category.index') ? 'active' : '' }}">
                Quản lí danh mục
                </a> --}}

                {{-- Khách hàng --}}

                <a href="{{ route('admin.user.index') }}"
                    class="admin-nav-link {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                    Quản lí khách hàng
                </a>


                {{-- Quản lí voucher --}}
                <a href="#" class="admin-nav-link">Quản lí voucher</a>
                {{-- <a href="{{ route('admin.voucher.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.voucher.index') ? 'active' : '' }}">
                Quản lí voucher
                </a> --}}

            </nav>

            <div class="admin-sidebar-footer">
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger admin-logout-btn">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <main class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar-title">@yield('page_title')</div>
            </header>

            <section class="admin-content">
                @yield('content')
            </section>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>