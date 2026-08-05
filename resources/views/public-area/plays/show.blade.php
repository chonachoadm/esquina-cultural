@extends('layouts.app')
@section('content')

    <section class="section-public py-4 flex-grow-1">

        @if (session('message'))
            <div class="mt-4 alert alert-warning">
                <small class="mx-4">{{ session('message') }}</small>
            </div>
        @elseif(session('success'))
            <div class="mt-4 alert alert-success">
                <small class="mx-4">{{ session('success') }}</small>
            </div>
        @elseif(session('error'))
            <div class="mt-4 alert alert-danger">
                <small class="mx-4">{{ session('error') }}</small>
            </div>
        @endif

        <a class="billboard-detail-back-button" href="{{ route('billboard') }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
        </a>

        <img class="mx-auto mt-4 img-fluid play-img" src="{{ upload_asset('images/plays/' . $play->cover_photo) }}"
            alt="{{ $play->title }}">

        <div class="row justify-content-center billboard-detail-copy">
            @guest
                <div class="col-12 col-md-6 col-lg-4 mt-4 row justify-content-center align-items-center p-0">
                    <a class="col-12 col-md-10 d-flex align-items-center justify-content-center rounded billboard-detail-buy-ticket-button"
                        href="{{ route('compra.create', $play) }}">Comprar entradas</a>
                </div>
            @endguest
            @auth
                <div class="col-12 col-md-6 col-lg-4 mt-4 row justify-content-between align-items-center p-0">
                    <a class="col-9 col-md-10 d-flex align-items-center justify-content-center rounded billboard-detail-buy-ticket-button"
                        href="{{ route('compra.create', $play) }}">Comprar entradas</a>
                    <div class="col-3 col-md-2 d-flex justify-content-center p-0">
                        @if (auth()->user()->savedPlays->contains($play->id))
                            <form action="{{ route('unsave.play', $play) }}" method="post">
                                @csrf
                                <button class="billboard-detail-save-play-button" type="submit">
                                    <img class="img-fluid" src="{{ asset('storage/images/icons/saved-icon-white.webp') }}"
                                        alt="Quitar obra de guardados">
                                </button>
                            </form>
                        @else
                            <form action="{{ route('save.play', $play) }}" method="post">
                                @csrf
                                <button class="billboard-detail-save-play-button" type="submit">
                                    <img class="img-fluid" src="{{ asset('storage/images/icons/not-saved-icon-white.webp') }}"
                                        alt="Guardar obra">
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endauth
            <div class="row justify-content-around my-4 w-100 px-0 px-md-2">
                <div class="col-12 col-lg-4 d-flex flex-column align-items-center my-4">
                    <h1 class="billboard-detail-h1">{{ $play->title }}</h1>
                    <small>{{ $play->duration }} minutos</small>
                    <div class="text-center my-4">
                        <a class="text-black link-hover" href="{{ route('teatros.show', $play->theater) }}">
                            <p class="m-0">{{ $play->theater->name }}</p>
                        </a>
                        <small class="billboard-detail-theater-address">{{ $play->theater->short_address }}</small>
                    </div>
                    <div class="d-flex gap-4">
                        @foreach ($play->schedule_slots as $slot)
                            <p class="rounded-pill border p-2 text-center billboard-detail-play-schedule">{{ $slot['day'] }}
                                {{ $slot['time'] }}</p>
                        @endforeach
                    </div>
                    <p><strong>Precio por entrada:</strong> $ {{ $play->ticket_price }}</p>
                </div>

                <hr class="d-block d-lg-none">

                <div class="col-12 col-lg-4 my-4">
                    <p>
                        {{ $play->description }}
                    </p>
                    <div class="p-4 rounded-3xl billboard-detail-tech-container">
                        <h2 class="text-center billboard-detail-tech-title">Ficha técnica</h2>
                        <ul class="list-unstyled">
                            @foreach ($play->users as $user)
                                <li>
                                    <p><strong>{{ $user->pivot->role }}: </strong><a class="link-hover"
                                            href="{{ route('user.profile', $user) }}">{{ $user->name }}</a></p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @if ($play->user === auth()->user())
                <form class="pb-4 d-flex justify-content-center" action="{{ route('obras.destroy', $play->id) }}"
                    method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"
                        onclick="return confirm('Estás segurx de querer eliminar {{ $play->title }}?')">Eliminar
                        Obra</button>
                </form>
            @endif

            @if ($play->comments)
                <hr class="billboard-detail-copy">
            @endif

            <div>
                @auth
                    <h2 class="billboard-detail-comment-title">¡Dejanos tu opinión!</h2>
                    <div class="row justify-content-center">
                        <form class="col-12 col-md-6" action="{{ route('comments.store', $play) }}" method="post">
                            @csrf
                            <div class="d-flex flex-column">
                                <textarea aria-label="Escribí tu comentario acá" name="body" id="body"
                                    class="p-2 w-100 rounded-2xl billboard-detail-comment-input" placeholder="Escribí tu comentario acá..."></textarea>
                                <button type="submit"
                                    class="align-self-end billboard-detail-comment-submit-button">Enviar</button>
                            </div>
                        </form>
                    </div>
                @endauth
                @if ($play->comments->count() > 0)
                    @guest
                        <h2 class="billboard-detail-comment-title">Chequeá las opiniones de nuestro público!</h2>
                    @endguest

                    <div class="mt-4">
                        @auth
                            <h3 class="billboard-detail-comment-subtitle">Otras opiniones</h3>
                        @endauth
                        <ul class="list-unstyled mt-4">
                            @foreach ($play->comments as $comment)
                                <li class="rounded-2xl p-2 my-2 billboard-detail-comment">
                                    <div class="d-flex justify-content-between">
                                        @if ($comment->user)
                                            <span class="billboard-detail-comment-owner"><a class="link-hover-comment"
                                                    href="{{ route('user.profile', $comment->user) }}">{{ $comment->user->name }}</a></span>
                                        @else
                                            <span class="billboard-detail-comment-owner"><em>Usuario inexistente</em></span>
                                        @endif
                                        <small
                                            class="billboard-detail-comment-time"><em>{{ $comment->created_at->diffForHumans() }}</em></small>
                                    </div>
                                    <p class="my-1">{{ $comment->comment_body }}</p>

                                    @auth
                                        @if ($comment->user_id === auth()->user()->id || auth()->user()->isAdmin())
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('¿Estás seguro de querer eliminar este comentario?')"
                                                    class="text-danger">Eliminar</button>
                                            </form>
                                        @endif
                                    @endauth
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h3 class="text-center py-4 m-0"><em>No hay comentarios aún.</em></h3>
                @endif
            </div>

        </div>
        </div>
    </section>

@endsection
