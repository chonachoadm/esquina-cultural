@extends('layouts.app')
@section('content')
    <section class="section-public pb-4 flex-grow-1">
        @if (session('message'))
            <div class="alert alert-warning m-4">
                <small class="mx-4">{{ session('message') }}</small>
            </div>
        @elseif(session('success'))
            <div class="alert alert-success m-4">
                <small class="mx-4">{{ session('success') }}</small>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger m-4">
                <small class="mx-4">{{ session('error') }}</small>
            </div>
        @endif

        <div class="d-flex d-md-none align-items-center justify-content-center landing-video">
            <video width="100%" autoplay muted playsinline
                poster="{{ asset('storage/images/isologo/isologo-blanco.webp') }}">
                <source src="{{ asset('storage/videos/video-landing-mobile.mp4') }}" type="video/mp4">
                Tu navegador no soporta el elemento de video.
            </video>
        </div>
        <div class="d-none d-md-flex align-items-center justify-content-center landing-video">
            <video width="100%" autoplay muted playsinline
                poster="{{ asset('storage/images/isologo/isologo-blanco-6-col.webp') }}">
                <source src="{{ asset('storage/videos/video-landing-desktop.mp4') }}" type="video/mp4">
                Tu navegador no soporta el elemento de video.
            </video>
        </div>

        <section class="my-4 py-4 billboard-detail-copy">
            <h1 class="billboard-detail-comment-title">
                Obras en cartelera
            </h1>
            <div class="d-block d-md-none">
                <div id="carouselExampleDark" class="carousel carousel-dark slide">
                    <div class="carousel-inner py-2 mx-auto">
                        @foreach ($plays as $play)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="10000">
                                <div class="rounded-3xl billboard-card p-2">
                                    <div class="billboard-img-container">
                                        <a href="{{ route('obras.show', $play) }}"><img class="img-fluid w-100"
                                                src="{{ upload_asset('images/plays/' . $play->cover_photo) }}"
                                                alt="{{ $play->title }}"></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="billboard-play-text">
                                            <div>
                                                <h2 class="landing-play-title"><a class="link-hover"
                                                        href="{{ route('obras.show', $play) }}">{{ $play->title }}</a>
                                                </h2>
                                                <p class="m-0">{{ $play->theater->name }}</p>
                                                <small
                                                    class="billboard-theater-address">{{ $play->theater->short_address }}</small>
                                            </div>
                                            <div class="ps-3">
                                                @foreach ($play->schedule_short_slots as $slot)
                                                    <small
                                                        class="rounded-pill bg-gray-100 px-2 py-1 billboard-play-schedule">{{ $slot['day'] }}
                                                        {{ $slot['time'] }}</small>
                                                @endforeach
                                            </div>
                                        </div>
                                        <a class="d-flex align-items-center justify-content-center rounded landing-ticket-button"
                                            href="{{ route('compra.create', $play) }}">Entradas</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row d-none d-md-flex justify-content-center gap-4 flex-wrap">
                @foreach ($plays as $play)
                    <div class="col-md-4 col-lg-3 mx-4 rounded-3xl billboard-card p-0">
                        <div class="billboard-img-container">
                            <a href="{{ route('obras.show', $play) }}"><img class="mx-auto img-fluid"
                                    src="{{ upload_asset('images/plays/' . $play->cover_photo) }}"
                                    alt="{{ $play->title }}"></a>
                        </div>
                        <div class="h-auto d-flex align-items-center justify-content-between p-4">
                            <div class="d-flex flex-column justify-content-between billboard-play-text">
                                <div>
                                    <h2 class="landing-play-title"><a class="link-hover"
                                            href="{{ route('obras.show', $play) }}">{{ $play->title }}</a></h2>
                                    <div>
                                        <p class="m-0">{{ $play->theater->name }}</p>
                                        <small
                                            class="billboard-theater-address">{{ $play->theater->short_address }}</small>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    @foreach ($play->schedule_short_slots as $slot)
                                        <small
                                            class="rounded-pill bg-gray-100 px-2 py-1 billboard-play-schedule">{{ $slot['day'] }}
                                            {{ $slot['time'] }}</small>
                                    @endforeach
                                </div>
                            </div>
                            <a class="d-flex align-items-center justify-content-center rounded landing-ticket-button"
                                href="{{ route('compra.create', $play) }}">Entradas</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="my-4 mx-auto about-us row">
            <div class="col-12 col-lg-6 m-0 mb-4 m-lg-4">
                <div class="row justify-content-center">
                    <div class="m-4 mx-auto">
                        <h2 class="h2-landing"><strong>Esquina Cultural</strong> es una plataforma digital con el objetivo
                            de promocionar y difundir el arte escénico <strong>autogestivo</strong> e
                            <strong>independiente</strong> bonaerense.</h2>
                        <ul class="landing-about-list my-4">
                            <li class="mb-2">
                                Adquirí tus <strong>entradas</strong>.
                            </li>
                            <li class="mb-2">
                                Publicá tu <strong>obra</strong>.
                            </li>
                            <li class="mb-2">
                                Registrá tu <strong>sala de teatro</strong>.
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row flex-column align-items-center justify-content-center mx-4">
                    <h6 class="text-center"><strong>Pronto suscripciones para más beneficios.</strong></h6>
                    <button disabled class="my-2 col-12 col-md-6 btn btn-gray">Suscribirse</button>
                    <small class="text-center">¡Con un pequeño monto ayudamos a que el arte siga creciendo!</small>
                </div>
            </div>
        </section>
        <section class="my-4 py-4 billboard-detail-copy">
            <h2 class="billboard-detail-comment-title">
                ¡Enterate de teatros cerca tuyo!
            </h2>
            <div class="row flex-wrap justify-content-center gap-4">
                @foreach ($theaters as $theater)
                    <a href="{{ route('teatros.show', $theater->id) }}"
                        class="col-12 col-sm-6 col-md-4 col-lg-3 text-black text-decoration-none">
                        <div class="d-flex flex-column justify-content-around p-3 rounded-3xl billboard-card">
                            <h3><strong>{{ $theater->name }}</strong></h3>
                            <p>{{ $theater->short_address }}</p>
                            <small class="billboard-play-schedule">{{ $theater->user->name }}</small>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="row justify-content-center">
                <a class="col-6 col-sm-4 col-md-2 text-center billboard-detail-comment-submit-button"
                    href="{{ route('teatros.index') }}">Ver más</a>
            </div>
            <hr>
        </section>

        <section class="my-4 billboard-detail-copy">
            <h3 class="billboard-detail-comment-title">
                Ingresá a tu cuenta para enterarte de todo lo que ofrecemos.
            </h3>
            <div class="row justify-content-center">
                <div
                    class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 py-4 rounded-3xl auth-forms">
                    <div role="tablist" class="w-100 d-flex justify-content-around">
                        <button type="button" id="login-tab" class="w-50 auth-form-tab active-form">Iniciar sesión</button>
                        <button type="button" id="register-tab" class="w-50 auth-form-tab">Crear cuenta</button>
                    </div>

                    <form class="w-100 px-4" id="login-form" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="d-flex flex-column w-100 mb-4">
                            <label for="email">Correo electrónico</label>
                            <input class="p-1 rounded auth-form-input" type="email" id="login-email" name="email"
                                value="{{ old('email') }}" />
                            @error('email')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-4">
                            <label for="password">Contraseña</label>
                            <input class="p-1 rounded auth-form-input" type="password" name="password"
                                id="login-password" />
                            @error('password')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div>
                            <button class="w-100 landing-auth-button" type="submit">Ingresar</button>
                        </div>
                    </form>

                    <form class="w-100 px-4" id="register-form" hidden action="{{ route('register') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column w-100 mb-4">
                            <label for="name">Nombre completo</label>
                            <input class="p-1 rounded auth-form-input" type="text" id="name" name="name"
                                value="{{ old('name') }}" />
                            @error('name')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-4">
                            <label for="email">Correo electrónico</label>
                            <input class="p-1 rounded auth-form-input" type="email" id="register-email" name="email"
                                value="{{ old('email') }}" />
                            @error('email')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-4">
                            <label for="password">Contraseña</label>
                            <input class="p-1 rounded auth-form-input" type="password" id="register-password"
                                name="password" />
                            @error('password')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-4">
                            <label for="password_confirmation">Confirmar contraseña</label>
                            <input class="p-1 rounded auth-form-input" type="password" id="password_confirmation"
                                name="password_confirmation" />
                        </div>
                        <div class="d-flex flex-column w-100 mb-4">
                            <label for="image">Foto de perfil</label>
                            <input class="p-1 rounded auth-form-input" type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp" data-cropper-aspect="1" data-cropper-width="500" data-cropper-height="500">
                            @error('image')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-4">
                            <label for="bio">Biografía</label>
                            <textarea class="p-1 rounded auth-form-input" id="bio" name="bio">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div>
                            <button class="w-100 landing-auth-button" type="submit">Registrarme</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
@endsection
