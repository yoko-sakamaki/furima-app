<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('user.mypage', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();

        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect('/mypage');
    }
}