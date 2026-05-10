<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>

<body>
    <header>
        <h1>Este es el header de layouts/app.blade.php</h1>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <h4>Este es el footer de layouts/app.blade.php</h4>
    </footer>
</body>
</html>