@extends('layouts.app')

@section('title', 'Inventory | Trendify')

@section('content')
<div class="app-content">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

           
            <div class="page-header">
                <div>
                    <h1 class="page-title">Inventory</h1>
                    <p class="page-subtitle text-muted">Manage your Inventories!</p>
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
                </div>
            </div>

          
            <form class="filters-card" method="GET" action="{{ route('products.index') }}">
                <div class="filters-grid">
                    <div class="filter-item">
                        <label class="filter-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="Women">Women</option>
                            <option value="Men">Men</option>
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
                                <option value="product_id">ID</option>
                                <option value="product_name">Name</option>
                                <option value="price">Price</option>
                                <option value="available_quantity">Stock</option>
                                <option value="created_at">Created</option>
                            </select>
                            <select name="dir" class="form-select" style="max-width:100px">
                                <option value="asc">↑</option>
                                <option value="desc">↓</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            
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
                            <tr>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image">
                                            <img src="{{ asset('uploads/floral_dress.png') }}" class="thumb-64" alt="Floral Summer Dress">
                                        </div>
                                        <div class="product-info">
                                            <div class="product-name">Floral Summer Dress</div>
                                            <div class="product-category">Women</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="product-id">#1001</span></td>
                                <td><span class="product-price">₱899.00</span></td>
                                <td><span class="product-stock">40 pcs</span></td>
                                <td><span class="product-type">Women</span></td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <div class="action-cell">
                                        <div class="dropdown">
                                            <button class="btn-action" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><h6 class="dropdown-header">Floral Summer Dress</h6></li>
                                                <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image">
                                            <img src="{{ asset('uploads/skinny_jeans.jpg') }}" class="thumb-64" alt="High-Waisted Skinny Jeans">
                                        </div>
                                        <div class="product-info">
                                            <div class="product-name">High-Waisted Skinny Jeans</div>
                                            <div class="product-category">Women</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="product-id">#1002</span></td>
                                <td><span class="product-price">₱1,199.00</span></td>
                                <td><span class="product-stock">50 pcs</span></td>
                                <td><span class="product-type">Women</span></td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <div class="action-cell">
                                        <div class="dropdown">
                                            <button class="btn-action" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><h6 class="dropdown-header">High-Waisted Skinny Jeans</h6></li>
                                                <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image">
                                            <img src="{{ asset('uploads/white_polo.jpg') }}" class="thumb-64" alt="Classic White Polo Shirt">
                                        </div>
                                        <div class="product-info">
                                            <div class="product-name">Classic White Polo Shirt</div>
                                            <div class="product-category">Men</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="product-id">#1003</span></td>
                                <td><span class="product-price">₱699.00</span></td>
                                <td><span class="product-stock">60 pcs</span></td>
                                <td><span class="product-type">Men</span></td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <div class="action-cell">
                                        <div class="dropdown">
                                            <button class="btn-action" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><h6 class="dropdown-header">Classic White Polo Shirt</h6></li>
                                                <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image">
                                            <img src="{{ asset('uploads/denim_jacket.jpg') }}" class="thumb-64" alt="Slim Fit Denim Jacket">
                                        </div>
                                        <div class="product-info">
                                            <div class="product-name">Slim Fit Denim Jacket</div>
                                            <div class="product-category">Men</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="product-id">#1004</span></td>
                                <td><span class="product-price">₱1,499.00</span></td>
                                <td><span class="product-stock">30 pcs</span></td>
                                <td><span class="product-type">Men</span></td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <div class="action-cell">
                                        <div class="dropdown">
                                            <button class="btn-action" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><h6 class="dropdown-header">Slim Fit Denim Jacket</h6></li>
                                                <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination removed for static view -->
            </div>
</div>
@endsection