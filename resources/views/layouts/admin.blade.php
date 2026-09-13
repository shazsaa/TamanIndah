<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Taman Indah') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @include('partials.theme-assets')

    <style>
        .admin-sidebar {
            width: 250px;
            height: 100vh;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: transform 0.3s;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .admin-sidebar > nav {
            padding-bottom: 1.5rem;
        }
        .admin-content {
            margin-left: 250px;
        }
        .sidebar-link {
            color: rgba(255,255,255,.75);
            text-decoration: none;
            padding: 0.6rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border-radius: 0.375rem;
            font-size: 0.9rem;
            transition: background .15s, color .15s;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(245, 166, 35, 0.2);
            color: #fff;
        }
        .sidebar-heading {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,.4);
            padding: 0.8rem 1rem 0.3rem;
        }
        @media (max-width: 991.98px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-content { margin-left: 0; }
        }
    </style>
</head>
<body class="bg-light">

    {{-- Sidebar --}}
    <aside class="admin-sidebar bg-success d-flex flex-column border-end border-white border-opacity-25" id="adminSidebar">
        <div class="p-3 border-bottom border-white border-opacity-25 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                <h5 class="fw-bold mb-0"><i class="bi bi-flower1 me-2"></i>Taman Indah</h5>
            </a>
            <small class="text-white-50">Admin Panel</small>
        </div>

        <nav class="flex-grow-1 p-3 d-flex flex-column gap-1">
            <div class="sidebar-heading">Main</div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="sidebar-heading mt-2">Catalog</div>

            <a href="{{ route('admin.categories.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Categories
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Products
            </a>

            <a href="{{ route('admin.stocks.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-data"></i> Stock
            </a>

            <div class="sidebar-heading mt-2">Transactions</div>

            <a href="{{ route('admin.orders.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Orders
            </a>

            <a href="{{ route('admin.customers.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Pelanggan
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card-2-front"></i> Payment Review
            </a>

            <div class="sidebar-heading mt-2">Reports</div>

            <a href="{{ route('admin.reports.sales') }}"
               class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i> Sales Report
            </a>
        </nav>

        <div class="p-3 border-top border-white border-opacity-25 flex-shrink-0">
            <div class="d-flex align-items-center gap-2 text-white-50 small">
                <i class="bi bi-person-circle fs-5"></i>
                <div class="flex-grow-1 text-truncate">
                    {{ auth()->user()->name }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-left me-1"></i> Log Out
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="admin-content">
        {{-- Topbar --}}
        <nav class="navbar navbar-light bg-white border-bottom shadow-sm px-3 px-lg-4">
            <button class="btn btn-outline-secondary d-lg-none me-2" type="button" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>

            <span class="navbar-text fw-semibold">
                @isset($header)
                    {{ $header }}
                @endisset
            </span>

            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ url('/') }}" class="btn btn-outline-success btn-sm" target="_blank">
                    <i class="bi bi-shop me-1"></i> View Store
                </a>
            </div>
        </nav>

        {{-- Flash messages --}}
        <div class="p-3 p-lg-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
