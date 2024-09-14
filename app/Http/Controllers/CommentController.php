<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $post = $comment->post;
        $comment->delete();

        return redirect()->route('posts.show', $post);
    }

    public function edit(Comment $comment): View
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validatedData);

        return redirect()->route('posts.show', $comment->post);
    }
}
