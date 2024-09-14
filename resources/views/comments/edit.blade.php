@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Edit Comment</h1>

        <form action="{{ route('comments.update', $comment) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea name="content" id="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('content', $comment->content) }}</textarea>
                @error('content')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Comment
                </button>
            </div>
        </form>
    </div>
@endsection
