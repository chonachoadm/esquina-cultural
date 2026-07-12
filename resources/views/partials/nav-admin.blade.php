<nav class="d-flex align-items-start py-4 nav-admin">
    <button class="d-flex d-md-none" id="nav-admin-open" type="button" aria-label="Abrir barra de navegación">
      <span class="nav-menu-button">☰</span>
    </button>
    <div class="w-100 d-flex align-items-center justify-content-center">
        <ul class="mb-0 me-4 w-100 d-none d-md-flex flex-row justify-content-end align-items-center flex-wrap">
            <li class="m-2"><a class="nav-link" href="{{ route('landing') }}">Inicio</a></li>
            <li class="m-2"><a class="nav-link" href="{{ route('billboard') }}">Cartelera</a></li>
            <li class="m-2"><a class="nav-link" href="{{ route('teatros.index') }}">Teatros</a></li>
            <li class="m-2"><a class="nav-link" href="{{ route('profile') }}">Mi perfil</a></li>
            <li class="m-2 nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dashboard</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('dashboard') }}">Panel de inicio</a></li>
                    <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('plays.index') }}">Lista obras</a></li>
                    <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('theaters.index') }}">Lista teatros</a></li>
                    <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('users.index') }}">Lista usuarios</a></li>
                    <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('purchases.index') }}">Lista compras</a></li>
                </ul>
            </li>
            <li class="m-2 d-flex align-items-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<div class="d-none justify-content-center align-items-center d-md-none mobile-nav-admin-open" id="mobile-nav-admin-menu">
    <button class="d-flex d-md-none" id="nav-admin-close" type="button" aria-label="Cerrar barra de navegación">
      <span class="navbar-toggler-icon">X</span>
    </button>
    <ul class="d-flex flex-column justify-content-center align-items-center p-0 m-0">
        <li class="m-2"><a class="nav-link" href="{{ route('billboard') }}">Cartelera</a></li>
        <li class="m-2"><a class="nav-link" href="{{ route('teatros.index') }}">Teatros</a></li>
        <li class="m-2"><a class="nav-link" href="{{ route('profile') }}">Mi perfil</a></li>
        <li class="m-2 nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dashboard</a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('dashboard') }}">Panel de inicio</a></li>
                <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('plays.index') }}">Lista obras</a></li>
                <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('theaters.index') }}">Lista teatros</a></li>
                <li class="dropdown-item"><a class="nav-link text-black" href="{{ route('users.index') }}">Lista usuarios</a></li>
            </ul>
        </li>
        <li class="m-2 d-flex align-items-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </li>
    </ul>
</div>