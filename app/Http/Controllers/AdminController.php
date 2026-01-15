<?php

namespace App\Http\Controllers;

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
        return view('admin.orders');
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
}
