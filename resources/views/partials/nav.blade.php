<nav>
    <ul>
        <li><a href="{{ route('billboard') }}">Cartelera</a></li>
        <li><a href="{{ route('teatros.index') }}">Teatros</a></li>
        @auth
        <li><a href="{{ route('profile') }}">Mi perfil</a></li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
            @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </li>
        @endauth
        @guest
        <li><a href="{{ route('showLogin') }}">Iniciar sesión</a></li>
        <li><a href="{{ route('showRegister') }}">Crear cuenta</a></li>
        @endguest
    </ul>
</nav>