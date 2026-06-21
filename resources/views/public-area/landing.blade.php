@extends('layouts.app')
@section('content')
<section class="section-public">
    @if(session('message'))
    <div class="alert alert-warning">
        <small>{{ session('message') }}</small>
    </div>
    @elseif(session('success'))
    <div class="alert alert-success">
        <small>{{ session('success') }}</small>
    </div>
    @elseif(session('error'))
    <div class="alert alert-error">
        <small>{{ session('error') }}</small>
    </div>
    @endif
    
    <div class="w-100 bg-dark d-flex align-items-center justify-content-center landing-video">
        <h1 class="text-white">Video</h1>
    </div>

    <section class="my-4 pt-4 billboard-detail-copy">
        <h2 class="billboard-detail-comment-title">
            Obras en cartelera
        </h2>
        <div>
            <div id="carouselExampleDark" class="carousel carousel-dark slide">
                <div class="carousel-inner py-2 mx-auto">
                    @foreach($plays as $play)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="10000">
                        <div class="rounded-3xl billboard-card p-2">
                            <div class="billboard-img-container">
                                <img class="img-fluid" src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="{{ $play->title }}">
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="billboard-play-text">
                                    <div>
                                        <h2 class="landing-play-title">{{ $play->title }}</h2>
                                        <p class="m-0">{{ $play->theater->name }}</p>
                                        <small class="billboard-theater-address">{{ $play->theater->short_address }}</small>
                                    </div>
                                    <div class="ps-3">
                                        @foreach($play->schedule_short_slots as $slot)
                                        <small class="billboard-play-schedule">{{ $slot['day'] }} {{ $slot['time'] }}</small>
                                        @endforeach
                                    </div>
                                </div>
                                <a class="d-flex align-items-center justify-content-center rounded landing-ticket-button" href="{{ route('obras.show', $play) }}">Entradas</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
        <hr>
    </section>
    <section class="my-4 billboard-detail-copy">
        <h2 class="billboard-detail-comment-title">
            ¿Qué es Esquina Cultural?
        </h2>
        <div class="my-4 mx-auto">
            <p>
                <strong>Esquina Cultural</strong> es una plataforma digital con el objetivo de promocionar y difundir el arte escénico <strong>autogestivo</strong> e <strong>independiente</strong> bonaerense.
            </p>
            <ul class="landing-about-list">
                <li class="mb-2">
                    <strong>Productores</strong> pueden publicar sus obras.
                </li>
                <li class="mb-2">
                    <strong>Espectadores</strong> pueden adquirir entradas.
                </li>
                <li class="mb-2">
                    <strong>Coordinadores</strong> o <strong>dueñxs</strong> de teatros pueden registrarlos para facilitar la administración de su cartelera.
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-center my-4">
            <img class="img-fluid w-25" src="{{ asset('storage/images/icons/isotipo-256px.png') }}" alt="Ícono de Esquina Cultural">
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center">
            <h6 class="text-center"><strong>Suscribite a nuestro newsletter para enterarte primero de lo que se viene.</strong></h6>
            <button class=" my-2 w-100 rounded billboard-detail-buy-ticket-button">Suscribirse</button>
            <small class="text-center">¡Con un pequeño monto ayudamos a que el arte siga creciendo!</small>
        </div>
        <hr>
    </section>
    <section class="my-4 billboard-detail-copy">
        <h2 class="billboard-detail-comment-title">
            ¡Enterate de teatros cerca tuyo!
        </h2>
        <div class="d-flex flex-column align-items-center gap-4">
            @foreach($theaters as $theater)
            <div class="d-flex flex-column justify-content-around p-3 rounded-3xl billboard-card">
                <h3><strong>{{ $theater->name }}</strong></h3>
                <p>{{ $theater->short_address }}</p>
                <small class="billboard-play-schedule">{{ $theater->user->name }}</small>
            </div>
            @endforeach
            <button class="billboard-detail-comment-submit-button">Ver más</button>
        </div>
        <hr>
    </section>

    
    <section class="my-4 billboard-detail-copy">
        <h3 class="billboard-detail-comment-title">
            Ingresá a tu cuenta para enterarte de todo lo que ofrecemos.
        </h3>

        <div class="d-flex flex-column align-items-center gap-4 py-4 rounded-3xl auth-forms">
            <div role="tablist" class="w-100 d-flex justify-content-around">
                <button type="button" id="login-tab" class="w-50 auth-form-tab active-form">Iniciar sesión</button>
                <button type="button" id="register-tab" class="w-50 auth-form-tab">Crear cuenta</button>
            </div>
            
            <form class="w-100 px-4" id="login-form" action="{{ route('login') }}" method="post">
                @csrf
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="email">Correo electrónico</label>
                    <input class="rounded auth-form-input" type="email" id="login-email" name="email" value="{{ old('email') }}" />
                    @error('email')
                    <div><small>{{ $message }}</small></div>
                    @enderror  
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="password">Contraseña</label>
                    <input class="rounded auth-form-input" type="password" name="password" id="login-password" />
                </div>
                <div>
                    <button class="w-100 landing-auth-button" type="submit">Ingresar</button>
                </div>
            </form>
            
            <form class="w-100 px-4" id="register-form" hidden action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="name">Nombre completo</label>
                    <input class="rounded auth-form-input" type="text" id="name" name="name" value="{{ old('name') }}" />
                    @error('name')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="email">Correo electrónico</label>
                    <input class="rounded auth-form-input" type="email" id="register-email" name="email" value="{{ old('email') }}" />
                    @error('email')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="password">Contraseña</label>
                    <input class="rounded auth-form-input" type="password" id="register-password" name="password" />
                    @error('password')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input class="rounded auth-form-input" type="password" id="password_confirmation" name="password_confirmation" />
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="image">Foto de perfil</label>
                    <input class="rounded auth-form-image-input" type="file" name="image" id="image">
                    @error('image')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="bio">Biografía</label>
                    <textarea class="rounded auth-form-input" type="text" id="bio" name="bio">{{ old('bio') }}</textarea>
                    @error('bio')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div>
                    <button class="w-100 landing-auth-button" type="submit">Registrarme</button>
                </div>
            </form>
        </div>

    </section>
</section>
@endsection
