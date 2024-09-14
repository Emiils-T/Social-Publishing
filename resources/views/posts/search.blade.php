@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Search Results</h1>

        <form action="{{ route('posts.search') }}" method="GET" class="mb-6">
            <div class="flex items-center">
                <input type="text" name="query" value="{{ $query }}" placeholder="Search posts..." class="form-input rounded-l-md flex-1 block w-full px-3 py-2 border border-gray-300 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <select name="category" class="form-select rounded-none block px-6 py-2 border border-gray-300 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Search
                </button>
            </div>
        </form>

        @if($posts->isEmpty())
            <p class="text-gray-600">No posts found matching your search criteria.</p>
        @else
            <div class="space-y-6">
                @foreach($posts as $post)
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                <a href="{{ route('posts.show', $post) }}" class="hover:underline">{{ $post->title }}</a>
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">{{ Str::limit($post->content, 200) }}</p>
                            <div class="mt-2">
                                @foreach($post->categories as $category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $category->name }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $posts->appends(['query' => $query, 'category' => $categoryId])->links() }}
            </div>
        @endif
    </div>
@endsection
