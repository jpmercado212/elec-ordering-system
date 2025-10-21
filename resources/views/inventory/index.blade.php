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
                        <form method="GET" action="{{ route('inventory.index') }}" class="d-inline">
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

          
            <form class="filters-card" method="GET" action="{{ route('inventory.index') }}">
                <div class="filters-grid">
                    <div class="filter-item">
                        <label class="filter-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" @selected(request('category')===$cat)>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-item">
                        <label class="filter-label">Stock Min</label>
                        <input type="number" name="stock_min" class="form-control" value="{{ request('stock_min') }}" placeholder="0">
                    </div>
                    
                    <div class="filter-item">
                        <label class="filter-label">Stock Max</label>
                        <input type="number" name="stock_max" class="form-control" value="{{ request('stock_max') }}" placeholder="1000">
                    </div>
                    
                    <div class="filter-item">
                        <label class="filter-label">Sort By</label>
                        <div class="d-flex gap-2">
                            <select name="sort" class="form-select">
                                @php $sort = request('sort','inventory_id'); @endphp
                                <option value="inventory_id" @selected($sort==='inventory_id')>Inventory ID</option>
                                <option value="product_name" @selected($sort==='product_name')>Product Name</option>
                                <option value="quantity_in_stock" @selected($sort==='quantity_in_stock')>Stock</option>
                                <option value="updated_at" @selected($sort==='updated_at')>Last Update</option>
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
                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            
            <div class="products-card">
                <div class="table-responsive">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="th-content">
                                        <span>Inventory ID</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Product Name</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Stock</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Last Update</span>
                                    </div>
                                </th>
                                <th style="width: 180px;">
                                    <div class="th-content">
                                        <span>Action</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventories as $inventory)
                            <tr data-product-name="{{ $inventory->product->product_name }}">
                                <td><span class="product-id">#{{ $inventory->inventory_id }}</span></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image">
                                            <img src="{{ asset('uploads/' . $inventory->product->image) }}" class="thumb-64" alt="{{ $inventory->product->product_name }}">
                                        </div>
                                        <div class="product-info">
                                            <div class="product-name">{{ $inventory->product->product_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="stock-display" id="stock-display-{{ $inventory->inventory_id }}">{{ $inventory->quantity_in_stock }} pcs</span>
                                    <input type="text" class="form-control stock-edit" id="stock-edit-{{ $inventory->inventory_id }}" value="{{ $inventory->quantity_in_stock }}" style="display: none; width: 80px;">
                                </td>
                                <td id="updated-at-{{ $inventory->inventory_id }}">{{ $inventory->updated_at->format('Y-m-d h:i A') }}</td>
                                <td style="width: 180px;">
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-primary edit-btn" data-inv-id="{{ $inventory->inventory_id }}">Edit</button>
                                        <button class="btn btn-sm btn-success save-btn" data-inv-id="{{ $inventory->inventory_id }}" style="display: none;">Save</button>
                                        <button class="btn btn-sm btn-secondary cancel-btn" data-inv-id="{{ $inventory->inventory_id }}" style="display: none;">Cancel</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($inventories->hasPages())
                    <div class="table-footer">
                        <div class="pagination-info">
                            Showing <span class="fw-semibold">{{ $inventories->firstItem() }}–{{ $inventories->lastItem() }}</span> of <span class="fw-semibold">{{ $inventories->total() }}</span>
                        </div>
                        
                        @php $q = request()->except('page'); @endphp
                        <nav class="pagination-nav">
                       
                            @if ($inventories->onFirstPage())
                                <span class="pagination-btn disabled" aria-disabled="true">
                                    <i class="bi bi-chevron-left"></i> Previous
                                </span>
                            @else
                                <a class="pagination-btn"
                                href="{{ $inventories->appends($q)->previousPageUrl() }}">
                                    <i class="bi bi-chevron-left"></i> Previous
                                </a>
                            @endif

                            <div class="pagination-numbers">
                                @for ($i = 1; $i <= $inventories->lastPage(); $i++)
                                    @if ($i == $inventories->currentPage())
                                        <span class="pagination-number active" aria-current="page">{{ $i }}</span>
                                    @else
                                        <a class="pagination-number"
                                        href="{{ $inventories->appends($q)->url($i) }}">{{ $i }}</a>
                                    @endif
                                @endfor
                            </div>

                            @if ($inventories->hasMorePages())
                                <a class="pagination-btn"
                                href="{{ $inventories->appends($q)->nextPageUrl() }}">
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
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="stockUpdateToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <div class="rounded me-2" style="width: 20px; height: 20px; background-color: #198754; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-check text-white" style="font-size: 12px;"></i>
            </div>
            <strong class="me-auto">Stock Updated</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Stock has been successfully updated!
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmStockModal" tabindex="-1" aria-labelledby="confirmStockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmStockModalLabel">Confirm Stock Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Save new stock for <strong id="modal-product-name"></strong> value:</p>
                <p><strong id="modal-quantity"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirm-save-btn">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all edit buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-inv-id');
            editStock(id);
        });
    });

    // Add event listeners to all save buttons
    document.querySelectorAll('.save-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-inv-id');
            saveStock(id);
        });
    });

    // Add event listeners to all cancel buttons
    document.querySelectorAll('.cancel-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-inv-id');
            cancelEdit(id);
        });
    });

    // Handle modal confirm button
    document.getElementById('confirm-save-btn').addEventListener('click', function() {
        const id = this.getAttribute('data-inventory-id');
        const newValue = this.getAttribute('data-new-value');
        
        // Hide the modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmStockModal'));
        modal.hide();
        
        // Perform the actual save
        actualSaveStock(id, newValue);
    });
});

function editStock(id) {
    // Hide the display span and show the input
    document.getElementById('stock-display-' + id).style.display = 'none';
    document.getElementById('stock-edit-' + id).style.display = 'inline-block';

    // Hide edit button and show save/cancel buttons
    document.querySelector('button.edit-btn[data-inv-id="' + id + '"]').style.display = 'none';
    document.querySelector('button.save-btn[data-inv-id="' + id + '"]').style.display = 'inline-block';
    document.querySelector('button.cancel-btn[data-inv-id="' + id + '"]').style.display = 'inline-block';

    // Focus on the input
    document.getElementById('stock-edit-' + id).focus();
}

function cancelEdit(id) {
    // Reset the input to original value
    const originalValue = document.getElementById('stock-display-' + id).textContent.replace(' pcs', '');
    document.getElementById('stock-edit-' + id).value = originalValue;

    // Show the display span and hide the input
    document.getElementById('stock-display-' + id).style.display = 'inline-block';
    document.getElementById('stock-edit-' + id).style.display = 'none';

    // Show edit button and hide save/cancel buttons
    document.querySelector('button.edit-btn[data-inv-id="' + id + '"]').style.display = 'inline-block';
    document.querySelector('button.save-btn[data-inv-id="' + id + '"]').style.display = 'none';
    document.querySelector('button.cancel-btn[data-inv-id="' + id + '"]').style.display = 'none';
}

function saveStock(id) {
    const newValue = document.getElementById('stock-edit-' + id).value;

    // Validate input
    if (newValue === '' || isNaN(newValue) || parseInt(newValue) < 0) {
        alert('Please enter a valid quantity (0 or greater)');
        return;
    }

    // Get product name from the table row
    const productName = document.querySelector(`tr [data-inv-id="${id}"]`).closest('tr').getAttribute('data-product-name');
    
    // Set modal content
    document.getElementById('modal-product-name').textContent = productName;
    document.getElementById('modal-quantity').textContent = newValue;
    
    // Store the inventory ID and new value for the confirm button
    const confirmBtn = document.getElementById('confirm-save-btn');
    confirmBtn.setAttribute('data-inventory-id', id);
    confirmBtn.setAttribute('data-new-value', newValue);
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('confirmStockModal'));
    modal.show();
}

function actualSaveStock(id, newValue) {
    // Make AJAX request to update the database
    fetch(`/inventory/${id}/update-stock`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: parseInt(newValue)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the display span with new value + " pcs"
            document.getElementById('stock-display-' + id).textContent = newValue + ' pcs';

            // Update the last updated time
            document.getElementById('updated-at-' + id).textContent = data.updated_at;

            // Show the display span and hide the input
            document.getElementById('stock-display-' + id).style.display = 'inline-block';
            document.getElementById('stock-edit-' + id).style.display = 'none';

            // Show edit button and hide save/cancel buttons
            document.querySelector('button.edit-btn[data-inv-id="' + id + '"]').style.display = 'inline-block';
            document.querySelector('button.save-btn[data-inv-id="' + id + '"]').style.display = 'none';
            document.querySelector('button.cancel-btn[data-inv-id="' + id + '"]').style.display = 'none';

            // Show success toast
            const toast = new bootstrap.Toast(document.getElementById('stockUpdateToast'));
            toast.show();
        } else {
            alert('Error updating stock: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating stock. Please try again.');
    });
}
</script>
@endsection