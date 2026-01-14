<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,declined,processing,shipped,delivered,cancelled',
            'admin_notes' => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function accept($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Order accepted successfully!');
    }

    public function decline(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => 'declined',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Order declined successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
}
