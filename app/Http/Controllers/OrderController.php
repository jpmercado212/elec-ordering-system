<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function list(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        if ($request->filled('total_min')) {
            $query->where('total_price', '>=', $request->total_min);
        }

        if ($request->filled('total_max')) {
            $query->where('total_price', '<=', $request->total_max);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $sort = $request->get('sort', 'order_date');
        $dir = $request->get('dir', 'desc');

        $orders = $query->orderBy($sort, $dir)
                        ->paginate($request->get('per_page', 10))
                        ->appends($request->all());

        return view('orders.order', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,completed'
        ]);

        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}