<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab');

        if ($tab === 'mylist' && auth()->check()) {
            $items = auth()->user()->likes()
                ->with('item')
                ->get()
                ->pluck('item')
                ->filter(function ($item) use ($search) {
                    return !$search || str_contains($item->name, $search);
                });
        } else {
            $items = Item::query()
                ->when($search, function ($query) use ($search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->when(auth()->check(), function ($query) {
                    return $query->where('user_id', '!=', auth()->id());
                })
                ->get();
        }

        return view('item.index', compact('items', 'search'));
    }

    public function show($id)
    {
        $item = Item::with([
            'user',
            'condition',
            'categories',
            'likes',
            'comments.user',
        ])->findOrFail($id);

        $isLiked = auth()->check()
            ? $item->likes->contains('user_id', auth()->id())
            : false;

        return view('item.show', compact('item', 'isLiked'));
    }
}