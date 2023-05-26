<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required|exists:posts,id', // Add this line to validate the post_id field
            'author_name' => 'required',
            'author_email' => 'required|email',
            'content' => 'required',
        ]);
    
        $comment = Comment::create($data);
    
        return response()->json($comment, 201);
    }
    
    public function index()
    {
        $comments = Comment::all();
    
        return response()->json($comments);
    }
    //
}
