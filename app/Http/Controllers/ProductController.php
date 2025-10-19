<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('inventory');

        if ($search = trim($request->input('search', ''))) {
            $query->where(function ($w) use ($search) {
                $w->where('product_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($cat = $request->input('category'))      $query->where('category', $cat);
        if ($min = $request->input('price_min'))     $query->where('price', '>=', (float) $min);
        if ($max = $request->input('price_max'))     $query->where('price', '<=', (float) $max);

        $allowedSorts = ['product_id','product_name','price','available_quantity','created_at'];
        $sort = in_array($request->input('sort'), $allowedSorts) ? $request->input('sort') : 'product_id';
        $dir  = $request->input('dir') === 'desc' ? 'desc' : 'asc';

        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10,20,30,50]) ? $perPage : 10;

        // Handle sorting by available_quantity (which comes from inventory)
        if ($sort === 'available_quantity') {
            $query->leftJoin('inventory', 'products.product_id', '=', 'inventory.product_id')
                  ->orderBy('inventory.quantity_in_stock', $dir)
                  ->select('products.*');
        } else {
            $query->orderBy($sort, $dir);
        }

        $products = $query->paginate($perPage)->appends($request->query());

        $categories = Product::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('products.index', compact('products', 'categories', 'sort', 'dir'));
    }    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name'       => ['required','string','max:255'],
            'description'        => ['nullable','string'],
            'price'              => ['required','numeric','min:0'],
            'available_quantity' => ['required','integer','min:0'],
            'category'           => ['nullable','string','max:100'],
            'image'              => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name  = time().'_'.preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $image->move(public_path('uploads'), $name);
            $validated['image'] = $name;
        }

        // Remove available_quantity from product data since it's stored in inventory
        $availableQuantity = $validated['available_quantity'];
        unset($validated['available_quantity']);

        $product = Product::create($validated);

        // Create inventory record with the available quantity
        \App\Models\Inventory::create([
            'product_id' => $product->product_id,
            'quantity_in_stock' => $availableQuantity,
        ]);

        return redirect()->route('products.index')->with('success', 'Product has been added successfully!');
    }

  
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

  
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name'       => ['required','string','max:255'],
            'description'        => ['nullable','string'],
            'price'              => ['required','numeric','min:0'],
            'available_quantity' => ['required','integer','min:0'],
            'category'           => ['nullable','string','max:100'],
            'image'              => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'remove_image'       => ['nullable','boolean'],
        ]);

      
        if ($request->hasFile('image')) {
        
            if ($product->image) {
                $old = public_path('uploads/'.$product->image);
                if (File::exists($old)) @File::delete($old);
            }
            $file = $request->file('image');
            $name = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads'), $name);
            $validated['image'] = $name;
        } elseif ($request->boolean('remove_image')) {
          
            if ($product->image) {
                $old = public_path('uploads/'.$product->image);
                if (File::exists($old)) @File::delete($old);
            }
            $validated['image'] = null;
        } else {
        
            unset($validated['image']);
        }

        // Handle available_quantity separately for inventory sync
        $availableQuantity = $validated['available_quantity'];
        unset($validated['available_quantity']);

        $product->update($validated);

        // Update or create inventory record
        $product->inventory()->updateOrCreate(
            ['product_id' => $product->product_id],
            ['quantity_in_stock' => $availableQuantity]
        );

        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            $path = public_path('uploads/'.$product->image);
            if (File::exists($path)) @File::delete($path);
        }
        
        // Delete inventory record first (if exists)
        $product->inventory()->delete();
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
