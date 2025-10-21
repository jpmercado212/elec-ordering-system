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
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="#">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-bag"></i>
                    <span>Order</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Product</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('inventory*') ? 'active' : '' }}" href="/inventory">
                    <i class="bi bi-boxes"></i>
                    <span>Inventory</span>
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