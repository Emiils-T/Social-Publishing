@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-4">{{ $user->name }}'s Profile</h1>
                <p class="text-gray-600 mb-4">Member since {{ $user->created_at->format('M d, Y') }}</p>

                @if($user->id === auth()->id())
                    <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Edit Profile
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-4 mt-4">{{ $user->name }}'s Posts</h2>
            @forelse($posts as $post)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">
                            <a href="{{ route('posts.show', $post) }}" class="text-gray-600 hover:underline">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <div class="text-gray-600 mb-2">{{ $post->created_at->format('M d, Y') }}</div>
                        <div class="mb-4">
                            @foreach($post->categories as $category)
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                                {{ $category->name }}
                            </span>
                            @endforeach
                        </div>
                        <p class="text-gray-700">{{ Str::limit($post->content, 200) }}</p>
                        <div class="mt-4">
                            <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:underline">
                                Read more
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">{{ $user->name }} hasn't written any posts yet.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
