<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        if ($item->user_id === $user->id) {
            return redirect('/item/' . $item_id);
        }

        $address = $user->addresses()->latest()->first();

        if (!$address && ($user->postal_code || $user->address)) {
            $address = (object)[
                'postal_code' => $user->postal_code,
                'address' => $user->address,
                'building' => $user->building,
            ];
        }

        return view('purchase.index', compact('item', 'user', 'address'));
    }

    public function store(Request $request, $item_id)
    {
        $user = auth()->user();
        $address = $user->addresses()->latest()->first();

        $errors = [];

        if (!$request->payment_method) {
            $errors['payment_method'] = '支払い方法を選択してください';
        }

        if (!$address && !$user->postal_code) {
            $errors['address'] = '配送先を登録してください';
        }

        if (!empty($errors)) {
            return redirect('/purchase/' . $item_id)->withErrors($errors);
        }

        $item = Item::findOrFail($item_id);

        // Stripe決済セッションを作成
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/purchase/' . $item_id . '/success') . '?session_id={CHECKOUT_SESSION_ID}&payment_method=' . $request->payment_method,
            'cancel_url' => url('/purchase/' . $item_id),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request, $item_id)
    {
        $user = auth()->user();
        $address = $user->addresses()->latest()->first();
        $item = Item::findOrFail($item_id);

        $user->purchases()->create([
            'item_id' => $item_id,
            'address_id' => $address ? $address->id : null,
            'payment_method' => $request->payment_method,
        ]);

        $item->update(['is_sold' => true]);

        return redirect('/');
    }

    public function editAddress($item_id)
    {
        $user = auth()->user();
        $address = $user->addresses()->latest()->first();

        if (!$address && ($user->postal_code || $user->address)) {
            $address = (object)[
                'postal_code' => $user->postal_code,
                'address' => $user->address,
                'building' => $user->building,
            ];
        }

        return view('purchase.address', compact('item_id', 'address'));
    }

    public function updateAddress(AddressRequest $request, $item_id)
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