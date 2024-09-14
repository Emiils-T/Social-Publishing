@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <article class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
                    @can('update', $post)
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1" role="menu" aria-orientation="vertical"
                                     aria-labelledby="options-menu">
                                    <a href="{{ route('posts.edit', $post) }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Edit
                                        Post</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
                                                role="menuitem"
                                                onclick="return confirm('Are you sure you want to delete this post?')">
                                            Delete Post
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
                <div class="flex items-center text-gray-600 mb-4">
                    <a href="{{ route('profile.show', $post->user) }}"
                       class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ $post->user->name }}
                    </a>
                    <span class="mx-2">•</span>
                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                </div>
                <div class="mb-4">
                    @foreach($post->categories as $category)
                        <span
                            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                        {{ $category->name }}
                    </span>
                    @endforeach
                </div>
                <div class="prose max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
        </article>
        <div class="mt-14 ">
            <h2 class="text-2xl font-bold mb-4 mt-2">Comments</h2>
            @forelse($post->comments as $comment)
                <div class="bg-white shadow-lg p-4 rounded-lg mb-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-grow">
                            <p class="mb-2">{{ $comment->content }}</p>
                            <div class="text-sm text-gray-600">
                                <span>By {{ $comment->user->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $comment->created_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                        @can('update', $comment)
                            <div class="relative ml-2" x-data="{ open: false }">
                                <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                        <a href="{{ route('comments.edit', $comment) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Edit Comment</a>
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100" role="menuitem" onclick="return confirm('Are you sure you want to delete this comment?')">Delete Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No comments yet.</p>
            @endforelse

            @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-6">
                    @csrf
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Add a comment</label>
                        <textarea name="content" id="content" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  required></textarea>
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 mb-4 border border-blue-600 text-sm font-medium rounded-md shadow-sm text-blue-600 bg-white hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            Post Comment
                        </button>
                    </div>
                </form>
            @else
                <p class="mt-6 text-gray-600">Please <a href="{{ route('login') }}"
                                                        class="text-blue-500 hover:underline">log in</a> to leave a
                    comment.</p>
            @endauth
        </div>
    </div>
@endsection
