<nav class="d-flex align-items-start py-4 nav">
    <button class="d-flex d-md-none" id="nav-open" type="button" aria-label="Abrir barra de navegación">
        <span class="nav-menu-button">☰</span>
    </button>
    <div class="w-100 d-flex align-items-center justify-content-center">
        <ul class="mb-0 me-4 w-100 d-none d-md-flex flex-row justify-content-end align-items-center flex-wrap">
            <li class="m-2"><a class="nav-link" href="{{ route('landing') }}">Inicio</a></li>
            <li class="m-2"><a class="nav-link" href="{{ route('billboard') }}">Cartelera</a></li>
            <li class="m-2"><a class="nav-link" href="{{ route('teatros.index') }}">Teatros</a></li>
            @auth
                <li class="m-2"><a class="nav-link" href="{{ route('profile') }}">Mi perfil</a></li>
                <li class="m-2 d-flex align-items-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </li>
            @endauth
            @guest
                <li class="m-2"><a class="nav-link" href="{{ route('login') }}">Ingresar a tu cuenta</a></li>
            @endguest
        </ul>
    </div>
</nav>


<div class="d-none justify-content-center align-items-center d-md-none mobile-nav-open" id="mobile-nav-menu">
    <button class="d-flex d-md-none" id="nav-close" type="button" aria-label="Cerrar barra de navegación">
        <span class="navbar-toggler-icon">X</span>
    </button>
    <ul class="d-flex flex-column justify-content-center align-items-center p-0 m-0">
        <li class="m-2"><a class="nav-link" href="{{ route('landing') }}">Inicio</a></li>
        <li class="m-2"><a class="nav-link" href="{{ route('billboard') }}">Cartelera</a></li>
        <li class="m-2"><a class="nav-link" href="{{ route('teatros.index') }}">Teatros</a></li>
        @auth
            <li class="m-2"><a class="nav-link" href="{{ route('profile') }}">Mi perfil</a></li>
            <li class="m-2 d-flex align-items-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </li>
        @endauth
        @guest
            <li class="m-2"><a class="nav-link" href="{{ route('login') }}">Ingresar a tu cuenta</a></li>
        @endguest
    </ul>
</div>
