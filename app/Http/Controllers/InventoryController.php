<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with('product');

        // Search functionality
        if ($search = trim($request->input('search', ''))) {
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($cat = $request->input('category')) {
            $query->whereHas('product', function ($q) use ($cat) {
                $q->where('category', $cat);
            });
        }

        // Stock filter
        if ($minStock = $request->input('stock_min')) {
            $query->where('quantity_in_stock', '>=', (int) $minStock);
        }
        if ($maxStock = $request->input('stock_max')) {
            $query->where('quantity_in_stock', '<=', (int) $maxStock);
        }

        // Sorting
        $allowedSorts = ['inventory_id', 'quantity_in_stock', 'updated_at'];
        $sort = in_array($request->input('sort'), $allowedSorts) ? $request->input('sort') : 'inventory_id';
        $dir = $request->input('dir') === 'desc' ? 'desc' : 'asc';

        // Handle product-related sorting
        if ($request->input('sort') === 'product_name') {
            $query->join('products', 'inventory.product_id', '=', 'products.product_id')
                  ->orderBy('products.product_name', $dir)
                  ->select('inventory.*');
        } else {
            $query->orderBy($sort, $dir);
        }

        // Pagination
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 30, 50]) ? $perPage : 10;

        $inventories = $query->paginate($perPage)->appends($request->query());

        // Get categories for filter dropdown
        $categories = \App\Models\Product::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('inventory.index', compact('inventories', 'categories'));
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->quantity_in_stock = $request->quantity;
        $inventory->save();

        // Convert updated_at to UTC+8
        $updatedAtUtc8 = $inventory->updated_at->copy()->setTimezone('Asia/Manila')->format('Y-m-d h:i A');
        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully',
            'updated_at' => $updatedAtUtc8
        ]);
    }
}
