<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Address;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();
        $address = $user->addresses()->latest()->first();

        return view('purchase.index', compact('item', 'user', 'address'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        $address = $user->addresses()->latest()->first();

        $purchase = $user->purchases()->create([
            'item_id' => $item_id,
            'address_id' => $address ? $address->id : null,
            'payment_method' => $request->payment_method,
        ]);

        $item->update(['is_sold' => true]);

        return redirect('/mypage');
    }

    public function editAddress($item_id)
    {
        $user = auth()->user();
        $address = $user->addresses()->latest()->first();

        return view('purchase.address', compact('item_id', 'address'));
    }

    public function updateAddress(\App\Http\Requests\AddressRequest $request, $item_id)
    {
        $user = auth()->user();

        $user->addresses()->create([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect('/purchase/' . $item_id);
    }
}