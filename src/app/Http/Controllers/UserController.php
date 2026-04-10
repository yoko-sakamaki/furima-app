<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $sellingItems = $user->items()->where('is_sold', false)->get();
        $purchasedItems = $user->purchases()->with('item')->get();

        return view('user.mypage', compact('user', 'sellingItems', 'purchasedItems'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $data = [
            'name' => $request->name,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ];

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')
                ->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect('/mypage');
    }
}