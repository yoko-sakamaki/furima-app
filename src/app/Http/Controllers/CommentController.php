<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $id)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $id,
            'body' => $request->body,
        ]);

        return redirect()->back();
    }
}