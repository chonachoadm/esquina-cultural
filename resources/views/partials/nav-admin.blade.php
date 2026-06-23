<nav class="nav-admin d-flex align-items-center">
    <div>
        <ul class="m-0 d-flex justify-content-center flex-wrap">
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
</nav>