<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Esquina Cultural</title>
</head>

<body>
    <header>
        @if(auth()->user()?->isAdmin())
        @include('partials.nav-admin')
        @else
        @unless(isset($hideNavbar) && $hideNavbar)
            @include('partials.nav')
        @endunless
        @endif
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <h4>Este es el footer de layouts/app.blade.php</h4>
    </footer>
</body>
</html>