<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::where('is_sold', false)
            ->when(auth()->check(), function ($query) {
                return $query->where('user_id', '!=', auth()->id());
            })
            ->get();

        return view('item.index', compact('items'));
    }
}