<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::with(['user', 'categories', 'comments']);

        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $posts = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post = Auth::user()->posts()->create($validatedData);
        $post->categories()->attach($validatedData['categories']);

        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post->update($validatedData);
        $post->categories()->sync($validatedData['categories']);

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categoryId = $request->input('category');

        $postsQuery = Post::query()->with(['user', 'categories']);

        if ($query) {
            $postsQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");
            });
        }

        if ($categoryId) {
            $postsQuery->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $posts = $postsQuery->latest()->paginate(10);
        $categories = Category::all();

        return view('posts.search', compact('posts', 'categories', 'query', 'categoryId'));
    }
}
