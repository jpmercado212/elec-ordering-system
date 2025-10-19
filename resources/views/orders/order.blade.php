<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders | Trendify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads/logo/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('uploads/logo/logo.png') }}">
    <meta name="theme-color" content="#6f42c1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="layout d-flex">

    <aside class="app-sidebar d-none d-lg-flex flex-column">
        <div class="sidebar-header">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('uploads/logo/logo.png') }}" alt="Trendify Logo" class="brand-logo-img">
                <span class="brand-text fw-bold">Trendify</span>
            </div>
        </div>

        <nav class="sidebar-nav flex-grow-1">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-grid"></i><span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('orders.list') }}">
                        <i class="bi bi-bag"></i><span>Orders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">
                        <i class="bi bi-box-seam"></i><span>Products</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a class="nav-link" href="#"><i class="bi bi-life-preserver"></i><span>Help</span></a>
            <a class="nav-link text-danger" href="#"><i class="bi bi-box-arrow-left"></i><span>Log out</span></a>
        </div>
    </aside>

    <div class="app-main flex-grow-1">

        <header class="app-topbar">
            <form class="topbar-search w-100" method="GET" action="{{ route('orders.list') }}">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" class="search-input" placeholder="Search order…"
                       value="{{ request('search') }}">
            </form>

            <div class="topbar-actions ms-auto">
                <button class="btn-topbar" type="button" title="Notifications">
                    <i class="bi bi-bell"></i>
                </button>

                <div class="user-profile">
                    <img src="{{ asset('uploads/profile/jp.jpg') }}"
                         alt="John Paul Mercado" class="user-avatar">
                    <div class="user-info d-none d-md-flex">
                        <div class="user-name">John Paul Mercado</div>
                        <div class="user-email">
                            <a href="mailto:johnpaulmercado@gmail.com" class="text-decoration-none">johnpaulmercado@gmail.com</a>
                        </div>
                    </div>
                    <i class="bi bi-chevron-down ms-2 d-none d-md-inline"></i>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="app-content">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Orders</h1>
                    <p class="page-subtitle text-muted">View and manage all customer orders</p>
                </div>

                <div class="header-actions">
                    <div class="showing-dropdown">
                        <span class="showing-label">Showing</span>
                        <form method="GET" action="{{ route('orders.list') }}" class="d-inline">
                            <select class="form-select form-select-sm showing-select" name="per_page"
                                    onchange="this.form.submit()">
                                @foreach([10,20,30,50] as $pp)
                                    <option value="{{ $pp }}" @selected(request('per_page', 10)==$pp)>{{ $pp }}</option>
                                @endforeach
                            </select>
                            @foreach(request()->except('per_page') as $k=>$v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>

            <form class="filters-card" method="GET" action="{{ route('orders.list') }}">
                <div class="filters-grid">
                    <div class="filter-item">
                        <label class="filter-label">Status</label>
                        <select name="status" class="form-select">
                            @php $st = request('status'); @endphp
                            <option value="">All</option>
                            <option value="pending" @selected($st==='pending')>Pending</option>
                            <option value="processing" @selected($st==='processing')>Processing</option>
                            <option value="completed" @selected($st==='completed')>Completed</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Total Min</label>
                        <input type="number" step="0.01" name="total_min" class="form-control"
                               value="{{ request('total_min') }}" placeholder="0.00">
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Total Max</label>
                        <input type="number" step="0.01" name="total_max" class="form-control"
                               value="{{ request('total_max') }}" placeholder="0.00">
                    </div>

                    <div class="filter-item">
                        <label class="filter-label">Sort By</label>
                        <div class="d-flex gap-2">
                            @php $sort = request('sort', 'order_date'); $dir = request('dir','desc'); @endphp
                            <select name="sort" class="form-select">
                                <option value="order_id" @selected($sort==='order_id')>ID</option>
                                <option value="order_date" @selected($sort==='order_date')>Order Date</option>
                                <option value="total_price" @selected($sort==='total_price')>Total</option>
                                <option value="order_status" @selected($sort==='order_status')>Status</option>
                            </select>
                            <select name="dir" class="form-select" style="max-width:110px">
                                <option value="asc" @selected($dir==='asc')>↑</option>
                                <option value="desc" @selected($dir==='desc')>↓</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('orders.list') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <div class="products-card">
                <div class="table-responsive">
                    <table class="products-table">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th class="text-end">Total Price</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($orders as $order)
                            @php
                                $status = strtolower($order->order_status ?? 'pending');
                                $pill = match ($status) {
                                    'pending' => 'status-pending',
                                    'processing' => 'status-processing',
                                    'completed' => 'status-completed',
                                    default => 'status-default'
                                };
                            @endphp
                            <tr>
                                <td>#{{ $order->order_id }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($order->order_date)
                                        {{ \Illuminate\Support\Carbon::parse($order->order_date)->format('Y-m-d H:i') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="text-end">₱{{ number_format($order->total_price, 2) }}</td>
                               <td>
                                <form method="POST" action="{{ route('orders.updateStatus', $order->order_id) }}" class="status-form">
                                    @csrf
                                    <div class="dropdown status-dropdown">
                                        <button class="btn btn-status {{ $pill }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ ucfirst($order->order_status) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button type="submit" name="order_status" value="pending" class="dropdown-item text-warning">
                                                    <i class="bi bi-hourglass-split me-1"></i> Pending
                                                </button>
                                            </li>
                                            <li>
                                                <button type="submit" name="order_status" value="processing" class="dropdown-item text-info">
                                                    <i class="bi bi-arrow-repeat me-1"></i> Processing
                                                </button>
                                            </li>
                                            <li>
                                                <button type="submit" name="order_status" value="completed" class="dropdown-item text-success">
                                                    <i class="bi bi-check-circle me-1"></i> Completed
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </form>
                            </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No orders found</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="table-footer">
                        <div class="pagination-info">
                            Showing <span class="fw-semibold">{{ $orders->firstItem() }}–{{ $orders->lastItem() }}</span>
                            of <span class="fw-semibold">{{ $orders->total() }}</span>
                        </div>

                        @php $q = request()->except('page'); @endphp
                        <nav class="pagination-nav">
                            @if ($orders->onFirstPage())
                                <span class="pagination-btn disabled" aria-disabled="true">
                                    <i class="bi bi-chevron-left"></i> Previous
                                </span>
                            @else
                                <a class="pagination-btn" href="{{ $orders->appends($q)->previousPageUrl() }}">
                                    <i class="bi bi-chevron-left"></i> Previous
                                </a>
                            @endif

                            <div class="pagination-numbers">
                                @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                    @if ($i == $orders->currentPage())
                                        <span class="pagination-number active" aria-current="page">{{ $i }}</span>
                                    @else
                                        <a class="pagination-number" href="{{ $orders->appends($q)->url($i) }}">{{ $i }}</a>
                                    @endif
                                @endfor
                            </div>

                            @if ($orders->hasMorePages())
                                <a class="pagination-btn" href="{{ $orders->appends($q)->nextPageUrl() }}">
                                    Next <i class="bi bi-chevron-right"></i>
                                </a>
                            @else
                                <span class="pagination-btn disabled" aria-disabled="true">
                                    Next <i class="bi bi-chevron-right"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>