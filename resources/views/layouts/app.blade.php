<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('storage/images/favicon/favicon.svg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Esquina Cultural</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        @if(auth()->user()?->isAdmin())
        @include('partials.nav-admin')
        @else
        @unless(isset($hideNavbar) && $hideNavbar)
            @include('partials.nav')
        @endunless
        @endif
    </header>
    <main class="flex-grow-1 d-flex">
        @yield('content')
    </main>
    <footer>
        @include('partials.footer')
    </footer>
</body>
</html>