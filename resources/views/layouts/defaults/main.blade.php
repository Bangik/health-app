<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Description">
    <meta name="author" content="Author">

    <title>@yield('title')</title>

    <link rel="canonical" href="{{ url()->current() }}">

    @include('layouts.partials.stylesheet')
    @include('layouts.partials.favicons')

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-800">
    @include('sweetalert::alert')

    @if (url()->current() != route('login'))
        @include('layouts.partials.navbar-main')
        <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
            @include('layouts.partials.sidebar')
            <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
    @endif
    <main>
        @yield('content')
    </main>
    @if (url()->current() != route('login'))
        </div>
        </div>
    @endif
</body>

</html>
