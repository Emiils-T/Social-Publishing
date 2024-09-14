<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>
<body class="bg-white">
<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="{{ url('/') }}" class="text-lg font-semibold">{{ 'Blog' }}</a>
            <div>
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-gray-700">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700">Register</a>
                @else
                    <a href="{{ route('posts.create') }}" class="text-sm text-gray-700">Create Post</a>
                    <a href="{{ route('profile.show', Auth::user()) }}" class="ml-4 text-sm text-gray-700">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="ml-4 text-sm text-gray-700">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>

<main class="container mx-auto mt-6 px-4">
    @yield('content')
</main>
</body>
</html>
