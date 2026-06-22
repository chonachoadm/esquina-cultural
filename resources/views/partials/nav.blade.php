<nav class="navbar navbar-expand-lg nav">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Desplegar barra de navegación">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item m-2"><a class="nav-link" href="{{ route('billboard') }}">Cartelera</a></li>
                <li class="nav-item m-2"><a class="nav-link" href="{{ route('teatros.index') }}">Teatros</a></li>
                @auth
                <li class="nav-item m-2"><a class="nav-link" href="{{ route('profile') }}">Mi perfil</a></li>
                <li class="nav-item m-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </li>
                @endauth
                @guest
                <li class="nav-item m-2"><a class="nav-link" href="{{ route('login') }}">Ingresar a tu cuenta</a></li>
                @endguest
            </ul>
        </div>
    </div>
</nav>