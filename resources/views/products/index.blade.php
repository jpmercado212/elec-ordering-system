<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products | Trendify</title>
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

    <!-- Sidebar -->
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
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- ✅ Make Order tab clickable -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.list') }}">
                        <i class="bi bi-bag"></i>
                        <span>Order</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('products.index') }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Product</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-people"></i>
                        <span>Customer</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-person-badge"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-receipt"></i>
                        <span>Billing</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-graph-up"></i>
                        <span>Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear"></i>
                        <span>Setting</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a class="nav-link" href="#">
                <i class="bi bi-life-preserver"></i>
                <span>Help</span>
            </a>
            <a class="nav-link text-danger" href="#">
                <i class="bi bi-box-arrow-left"></i>
                <span>Log out</span>
            </a>
        </div>
    </aside>

    <!-- Main -->
    <div class="app-main flex-grow-1">

        <!-- Topbar -->
        <header class="app-topbar">
            <div class="topbar-search">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search" value="{{ request('search') }}">
            </div>

            <div class="topbar-actions">
                <button class="btn-topbar">
                    <i class="bi bi-bell"></i>
                </button>
                <div class="user-profile">
                    <img src="{{ asset('uploads/profile/ian.jpg') }}" alt="Clarisse Rivera" class="user-avatar">
                    <div class="user-info d-none d-md-block">
                        <div class="user-name">Jan Adrian E. Sideno</div>
                        <div class="user-email">
                            <a href="mailto:janadriansideno@gmail.com" class="text-decoration-none">janadriansideno@gmail.com</a>
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

            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Product</h1>
                    <p class="page-subtitle text-muted">Manage your product inventory</p>
                </div>
                
                <div class="header-actions">
                    <div class="showing-dropdown">
                        <span class="showing-label">Showing</span>
                        <form method="GET" action="{{ route('products.index') }}" class="d-inline">
                            <select class="form-select form-select-sm showing-select" name="per_page" onchange="this.form.submit()">
                                @foreach([10,20,30,50] as $pp)
                                    <option value="{{ $pp }}" @selected(request('per_page', 10)==$pp)>{{ $pp }}</option>
                                @endforeach
                            </select>
                            @foreach(request()->except('per_page') as $k=>$v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                        </form>
                    </div>

                    <!-- ❌ fixed typo: products.cdeate → ✅ products.create -->
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        <span>Add New Product</span>
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <form class="filters-card" method="GET" action="{{ route('products.index') }}">
                <div class="filters-grid">
                    <div class="filter-item">
                        <label class="filter-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @php $categories = $categories ?? \App\Models\Product::whereNotNull('category')->distinct()->orderBy('category')->pluck('category'); @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" @selected(request('category')===$cat)>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-item">
                        <label class="filter-label">Price Min</label>
                        <input type="number" step="0.01" name="price_min" class="form-control" value="{{ request('price_min') }}" placeholder="0.00">
                    </div>
                    
                    <div class="filter-item">
                        <label class="filter-label">Price Max</label>
                        <input type="number" step="0.01" name="price_max" class="form-control" value="{{ request('price_max') }}" placeholder="0.00">
                    </div>
                    
                    <div class="filter-item">
                        <label class="filter-label">Sort By</label>
                        <div class="d-flex gap-2">
                            <select name="sort" class="form-select">
                                @php $sort = request('sort','product_id'); @endphp
                                <option value="product_id" @selected($sort==='product_id')>ID</option>
                                <option value="product_name" @selected($sort==='product_name')>Name</option>
                                <option value="price" @selected($sort==='price')>Price</option>
                                <option value="available_quantity" @selected($sort==='available_quantity')>Stock</option>
                                <option value="created_at" @selected($sort==='created_at')>Created</option>
                            </select>
                            <select name="dir" class="form-select" style="max-width:100px">
                                @php $dir = request('dir','asc'); @endphp
                                <option value="asc" @selected($dir==='asc')>↑</option>
                                <option value="desc" @selected($dir==='desc')>↓</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <!-- Products Table -->
            <div class="products-card">
                <div class="table-responsive">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="th-content">
                                        <span>Product Name</span>
                                        <i class="bi bi-chevron-down sort-icon"></i>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Product ID</span>
                                        <i class="bi bi-chevron-down sort-icon"></i>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Price</span>
                                        <i class="bi bi-chevron-down sort-icon"></i>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Stock</span>
                                        <i class="bi bi-chevron-down sort-icon"></i>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Type</span>
                                        <i class="bi bi-chevron-down sort-icon"></i>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Status</span>
                                        <i class="bi bi-chevron-down sort-icon"></i>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content justify-content-end">
                                        <span>Action</span>
                                        <i class="bi bi-chevron-down sort-icon"></i>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $p)
                                @php
                                    $status = strtolower($p->order_status ?? $p->status ?? 'active');
                                    $statusClass = [
                                        'pending' => 'status-pending',
                                        'active' => 'status-active',
                                        'inactive' => 'status-inactive',
                                        'on sale' => 'status-sale',
                                        'bouncing' => 'status-bouncing',
                                        'processing' => 'status-processing',
                                        'completed' => 'status-completed',
                                    ][$status] ?? 'status-default';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="product-cell">
                                            <div class="product-image">
                                                @if($p->image)
                                                    <img src="{{ asset('uploads/'.$p->image) }}" class="thumb-64" alt="{{ $p->product_name }}">
                                                @else
                                                    <img src="{{ asset('uploads/default.jpg') }}" class="thumb-64" alt="No Image">
                                                @endif
                                            </div>
                                            <div class="product-info">
                                                <div class="product-name">{{ $p->product_name }}</div>
                                                <div class="product-category">{{ $p->category ?: 'Uncategorized' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="product-id">#{{ $p->product_id }}</span></td>
                                    <td><span class="product-price">₱{{ number_format($p->price, 2) }}</span></td>
                                    <td><span class="product-stock">{{ number_format($p->available_quantity) }} {{ $p->category === 'Juice' || $p->category === 'Oil' ? 'lt' : 'pcs' }}</span></td>
                                    <td><span class="product-type">{{ $p->category ?: '—' }}</span></td>
                                    <td><span class="status-badge {{ $statusClass }}">{{ ucfirst($status) }}</span></td>
                                    <td>
                                        <div class="action-cell">
                                            <div class="dropdown">
                                                <button class="btn-action" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><h6 class="dropdown-header">{{ $p->product_name }}</h6></li>
                                                    <li><a class="dropdown-item" href="{{ route('products.edit', $p) }}"><i class="bi bi-pencil"></i> Edit</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form method="POST" action="{{ route('products.destroy', $p) }}" onsubmit="return confirm('Delete this product?')">
                                                            @csrf @method('DELETE')
                                                            <button class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>No products found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="table-footer">
                        <div class="pagination-info">
                            Showing <span class="fw-semibold">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span> of <span class="fw-semibold">{{ $products->total() }}</span>
                        </div>

                        @php $q = request()->except('page'); @endphp
                        <nav class="pagination-nav">
                            @if ($products->onFirstPage())
                                <span class="pagination-btn disabled" aria-disabled="true">
                                    <i class="bi bi-chevron-left"></i> Previous
                                </span>
                            @else
                                <a class="pagination-btn" href="{{ $products->appends($q)->previousPageUrl() }}">
                                    <i class="bi bi-chevron-left"></i> Previous
                                </a>
                            @endif

                            <div class="pagination-numbers">
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    @if ($i == $products->currentPage())
                                        <span class="pagination-number active" aria-current="page">{{ $i }}</span>
                                    @else
                                        <a class="pagination-number" href="{{ $products->appends($q)->url($i) }}">{{ $i }}</a>
                                    @endif
                                @endfor
                            </div>

                            @if ($products->hasMorePages())
                                <a class="pagination-btn" href="{{ $products->appends($q)->nextPageUrl() }}">
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