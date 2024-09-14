@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Posts</h1>

    <div class="mb-6">
        <form action="{{ route('posts.search') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search posts..." class="form-input rounded-l-md flex-1 block w-full px-3 py-2 border border-gray-300 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <select name="category" class="form-select rounded-none block px-6 pl-3 py-2 border border-gray-300 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Search</button>
        </form>
    </div>

    @foreach($posts as $post)
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-bold mb-2">
                <a href="{{ route('posts.show', $post) }}" class="text-gray-900 hover:underline">{{ $post->title }}</a>
            </h2>
            <p class="text-gray-600 mb-4">By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
            <p class="mb-4">{{ Str::limit($post->content, 200) }}</p>
            <div class="flex justify-between items-center">
                <div>
                    @foreach($post->categories as $category)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">{{ $category->name }}</span>
                    @endforeach
                </div>
                <span class="text-gray-600">{{ $post->comments->count() }} comments</span>
            </div>
        </div>
    @endforeach


    <div class="pb-2">
        {{ $posts->links() }}
    </div>
@endsection
