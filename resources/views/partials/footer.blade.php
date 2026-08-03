<div class="py-2 footer">
    <div class="row w-100 align-items-center justify-content-around gap-4 mx-auto">
        <div class="col-10 col-sm-4 col-lg-3 row justify-content-center my-2">
            <a class="d-flex justify-content-center" href="{{ route('landing') }}">
                <img class="w-75 img-fluid" src="{{ asset('storage/images/isologo/isologo-amarillo-blanco.svg') }}"
                    alt="Logo Esquina Cultural">
            </a>
        </div>
        <div class="col-10 col-sm-4 col-lg-3 my-2">
            <ul class="p-0">
                <li class="m-2 footer-list-item"><a class="nav-link link-hover-footer"
                        href="{{ route('landing') }}">Inicio</a></li>
                <li class="m-2 footer-list-item"><a class="nav-link link-hover-footer"
                        href="{{ route('billboard') }}">Cartelera</a></li>
                <li class="m-2 footer-list-item"><a class="nav-link link-hover-footer"
                        href="{{ route('teatros.index') }}">Teatros</a></li>
                @auth
                    <li class="m-2 footer-list-item"><a class="nav-link link-hover-footer" href="{{ route('profile') }}">Mi
                            perfil</a></li>
                    <li class="m-2 footer-list-item d-flex align-items-center">
                        <form class="link-hover-footer" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Cerrar sesión</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li class="m-2 footer-list-item"><a class="nav-link link-hover-footer"
                            href="{{ route('login') }}">Ingresar a tu cuenta</a></li>
                @endguest
            </ul>
        </div>
        <div class="col-10 col-sm-4 col-lg-3 m-2">
            <ul class="p-0">
                <li class="d-flex align-items-center gap-2 mb-4 footer-list-item"><img class="img-fluid footer-icon"
                        src="{{ asset('storage/images/icons/phone-icon.svg') }}" alt="Teléfono">
                    <p class="m-0 text-white text-decoration-none">+54 9 11 5329-7379</p>
                </li>
                <li class="footer-list-item">
                    <a class="d-flex align-items-center gap-2 mb-4 link-hover-footer"
                        href="https://mail.google.com/mail/?view=cm&fs=1&to=ignacio.lopez01@davinci.edu.ar"
                        target="_blank" rel="noopener noreferrer">
                        <img class="img-fluid footer-icon" src="{{ asset('storage/images/icons/mail-icon.svg') }}"
                            alt="Correo electrónico">
                        <p class="m-0">esquinacultural@gmail.com</p>
                    </a>
                </li>
                <li class="footer-list-item">
                    <a class="d-flex align-items-center gap-2 mb-4 link-hover-footer"
                        href="https://www.instagram.com/chonachin?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        target="_blank" rel="noopener noreferrer">
                        <img class="img-fluid footer-icon" src="{{ asset('storage/images/icons/insta-icon.svg') }}"
                            alt="Instagram">
                        <p class="m-0">@esquinacultural</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="d-flex flex-column justify-content-center align-items-center footer">
        <p class="fs-5">© {{ now()->format('Y') }} <strong>Esquina Cultural</strong></p>
    </div>
</div>
