<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle($id)
    {
        $like = Like::where('user_id', auth()->id())
            ->where('item_id', $id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'item_id' => $id,
            ]);
        }

        return redirect()->back();
    }
}