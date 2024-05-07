<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $posts = Post::all();
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $userId = auth()->id();
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $userId
        ]);
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $post->user_id,
        ]);
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }

    public function hide(Post $post , User $user)
    {
        $post->update(['hidden' => true]);
        return response()->json(['message' => 'Post hidden successfully']);
    }
}
