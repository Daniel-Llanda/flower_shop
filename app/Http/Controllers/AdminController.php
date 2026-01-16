<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PosItem;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $posItems = PosItem::all();
        return view('admin.dashboard', compact('posItems'));

    }

    public function users()
    {
        return view('admin.users');
    }

    public function orders()
    {
        return view('admin.orders', [
            'pendingOrders' => Order::where('status', 'pending')->latest()->get(),
            'otherOrders'   => Order::whereIn('status', ['completed', 'cancelled'])->latest()->get(),
        ]);
    }

    public function flowers()
    {
        return view('admin.flowers');
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_price' => 'required|numeric|min:0',
            'item_type' => 'required|in:bundle,per_stem',
        ]);

        PosItem::create($request->all());

        return redirect()->back()->with('success', 'POS item added successfully.');
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'customer_name'   => 'required|string|max:255',
            'contact_number'  => 'required|string|max:50',
            'order_type'      => 'required|in:pickup,delivery',
            'payment_mode'    => 'required|string|max:50',
            'cart'            => 'required|string',
            'total_amount'    => 'required|numeric|min:0',
        ]);

        // Create Order (default status: pending)
        $order = Order::create([
            'customer_name'  => $request->customer_name,
            'contact_number' => $request->contact_number,
            'address'        => $request->address,
            'order_type'     => $request->order_type,
            'payment_mode'   => $request->payment_mode,
            'delivery_time'  => $request->delivery_time,
            'message'        => $request->message,
            'total_amount'   => $request->total_amount,
            'status'         => 'pending', // 👈 important
        ]);

        $cartItems = json_decode($request->cart, true);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_name'=> $item['name'],
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        return redirect()->back()->with('success', 'Order placed successfully!');
    }

    public function complete(Order $order)
    {
        $order->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Order marked as completed.');
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Order cancelled.');
    }


}
