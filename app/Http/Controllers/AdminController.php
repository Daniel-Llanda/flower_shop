<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PosItem;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        $posItems = PosItem::all();
        $colors = PosItem::whereNotNull('item_color')
            ->distinct()
            ->pluck('item_color');

        $occasions = PosItem::whereNotNull('item_occasion')
            ->where('item_occasion', '!=', '')
            ->distinct()
            ->pluck('item_occasion');
        return view('admin.dashboard', compact('posItems', 'colors', 'occasions'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function orders()
    {
        return view('admin.orders', [
            'pendingOrders' => Order::where('status', 'pending')->latest()->get(),
        ]);
    }

    public function flowers()
    {
        $flowers = Flower::latest()->get();
        return view('admin.flowers', compact('flowers'));
    }

    public function reports(Request $request)
    {
    // BASE QUERY (used for counts)
        $baseQuery = Order::query();

        // COUNTS DEFAULT = ALL ORDERS
        $counts = [
            'pending'   => (clone $baseQuery)->where('status', 'pending')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
        ];

        // EMPTY orders by default (table hidden)
        $orders = collect();

        // IF FILTER IS USED
        if ($request->hasAny(['status', 'from', 'to'])) {

            $filteredQuery = Order::query();

            if ($request->status) {
                $filteredQuery->where('status', $request->status);
            }

            if ($request->from && $request->to) {
                $filteredQuery->whereBetween('created_at', [
                    $request->from . ' 00:00:00',
                    $request->to . ' 23:59:59'
                ]);
            }

            // TABLE DATA
            $orders = $filteredQuery->latest()->get();

            // UPDATE COUNTS BASED ON FILTER
            $counts['pending']   = (clone $filteredQuery)->where('status', 'pending')->count();
            $counts['completed'] = (clone $filteredQuery)->where('status', 'completed')->count();
            $counts['cancelled'] = (clone $filteredQuery)->where('status', 'cancelled')->count();
        }

        return view('admin.reports', compact('orders', 'counts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name'  => 'required|string|max:255',
            'item_price' => 'required|numeric|min:0',
            'item_type'  => 'required|in:bundle,per_stem',
            'item_color' => 'required|in:primary,secondary,success,danger,warning,info,dark',
            'item_occasion'  => 'nullable|string|max:255',
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

    public function editPosItems()
    {
        $posItems = PosItem::all();
        return view('admin.edit_pos_items', compact('posItems'));
    }
    public function updatePosItems(Request $request, $id)
    {
        $request->validate([
            'item_name'  => 'required|string|max:255',
            'item_price' => 'required|numeric|min:0',
            'item_type'  => 'required|in:bundle,per_stem',
            'item_color' => 'required|in:primary,secondary,success,danger,warning,info,dark',
        ]);
        $posItem = PosItem::findOrFail($id);
        $posItem->update($request->all());

        return redirect()->route('pos-items.edit')->with('success', 'POS item updated successfully.');
    }

    public function pendingOrders()
    {
        $orders = Order::where('status', 'pending')->latest()->get();
        return view('admin.pending', compact('orders'));
    }   
    public function completedOrders()
    {
        $orders = Order::where('status', 'completed')->latest()->get();
        return view('admin.completed', compact('orders'));
    }
    public function cancelledOrders()
    {
        $orders = Order::where('status', 'cancelled')->latest()->get();
        return view('admin.cancelled', compact('orders'));
    }

    public function profile()
    {
        return view('admin.profile');
    }
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admins,email,' . auth()->guard('admin')->id(),
        ]);

        $admin = auth()->guard('admin')->user();
        $admin->email = $request->email;
        $admin->save();

        return redirect()->back()->with('success', 'Email updated successfully.');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]); 
        return redirect()->back()->with('success', 'Password updated successfully.');
    }


    public function downloadPdf(Request $request)
    {
        $query = Order::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        $orders = $query->latest()->get();

        $pdf = Pdf::loadView('admin.reports_pdf', compact('orders'));

        return $pdf->download('filtered-orders-report.pdf');
    }

    public function storeFlower(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('flowers', 'public');
        }

        Flower::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Flower added successfully');
    }

    public function destroy($id)
    {
        PosItem::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'POS item deleted successfully.');
    }

    public function updateFlower(Request $request, $id)
    {
        $flower = Flower::findOrFail($id);

        $flower->update($request->only('name','price','description'));

        return back()->with('success', 'Flower updated successfully.');
    }

    public function destroyFlower($id)
    {
        Flower::findOrFail($id)->delete();
        return back()->with('success', 'Flower deleted successfully.');
    }




    

}
