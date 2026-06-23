<nav class="nav d-flex align-items-center">
    <div>
        <ul class="w-100 d-flex justify-content-center align-items-center flex-wrap">
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