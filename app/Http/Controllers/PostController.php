<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->where('hidden', false)->get();
        return view('posts.index', compact('posts'));
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
    public function store(Request $request, User $user)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $userId = auth()->id() ;
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
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $user = auth()->user();
        if (auth()->id() != $post->user_id && $user->usertype === 'user') {
            abort(403, 'Unauthorized action.');
        }
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post )
    {
        $user = auth()->user();
        if (auth()->id() !== $post->user_id && $user->usertype === 'user') {
            abort(403, 'Unauthorized action.');
        }
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
    public function destroy(Post $post )
    {
        $user = auth()->user();
        if (auth()->id() !== $post->user_id && $user->usertype === 'user') {
            abort(403, 'Unauthorized action.');
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post soft deleted successfully.');
    }

    public function hide(Post $post)
    {
        $user = auth()->user();
        if (auth()->id() !== $post->user_id && $user->usertype === 'user') {
            abort(403, 'Unauthorized action.');
        }
        $post->update(['hidden' => true]);
        return response()->json(['message' => 'Post hidden successfully']);
    }
}
