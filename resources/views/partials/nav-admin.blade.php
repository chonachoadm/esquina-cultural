<nav class="my-4">
    <ul class="d-flex justify-content-around">
        <li><a href="{{ route('billboard') }}">Cartelera</a></li>
        <li><a href="{{ route('teatros.index') }}">Teatros</a></li>
        <li><a href="{{ route('profile') }}">Mi perfil</a></li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dashboard</a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a class="nav-link" href="{{ route('dashboard') }}">Panel de inicio</a></li>
                <li class="dropdown-item"><a class="nav-link" href="{{ route('plays.index') }}">Lista obras</a></li>
                <li class="dropdown-item"><a class="nav-link" href="{{ route('theaters.index') }}">Lista teatros</a></li>
                <li class="dropdown-item"><a class="nav-link" href="{{ route('users.index') }}">Lista usuarios</a></li>
            </ul>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
            @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </li>
    </ul>
</nav>