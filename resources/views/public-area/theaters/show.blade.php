@extends('layouts.app')

@section('content')
    <section class="section-public py-4 flex-grow-1">

        @if (session('message'))
            <div class="alert alert-warning">
                <small>{{ session('message') }}</small>
            </div>
        @elseif(session('success'))
            <div class="w-50 mx-auto alert alert-success mt-4">
                <small>{{ session('success') }}</small>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                <small>{{ session('error') }}</small>
            </div>
        @endif


        <a class="billboard-detail-back-button" href="{{ route('teatros.index') }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
        </a>


        <div class="my-4 d-flex align-items-center justify-content-center">
            <div class="my-4 rounded-3xl billboard-detail-copy billboard-card">
                <div class="container-img-theater">
                    <img class="w-100 img img-fluid" src="{{ asset('storage/images/theaters/' . $theater->image) }}"
                        alt="Banner de {{ $theater->name }}">
                </div>
                <div class="my-4 p-2">
                    <div class="d-flex align-items-center justify-content-center gap-4">
                        <h1 class="m-0 text-center fw-bold">{{ $theater->name }}</h1>
                        @auth
                        <div>
                            @if ($theater->user_id === auth()->id())
                                <a href="{{ route('teatros.edit', $theater->id) }}">
                                    <img class="img-fluid" src="{{ asset('storage/images/icons/edit-icon-25.webp') }}" alt="Editar teatro">
                                </a>
                            @endif
                        </div>
                        @endauth
                    </div>
                        <p class="text-center">{{ $theater->bio }}</p>
                </div>
                <div class="row flex-column align-items-center py-4">
                    <small class="fst-italic text-center">{{ $theater->short_address }}</small>
                    <div id="map-view" class="col-12 col-md-6"></div>

                    <input type="hidden" id="lat" value="{{ $theater->latitude }}">
                    <input type="hidden" id="lng" value="{{ $theater->longitude }}">
                </div>

                @if ($theater->plays->count() > 0)
                    <div class="p-2">
                        <h2 class="fs-4 fw-bold text-center mt-4">
                            Obras encartelera
                        </h2>
                        <div class="row justify-content-center">
                            @foreach ($theater->plays as $play)
                                @if ($play->status === 'verified')
                                    <div class="col-11 col-sm-6 col-md-4 col-lg-3 m-4 p-0 rounded-3xl billboard-card">
                                        <div class="billboard-img-container">
                                            <img class="img-fluid"
                                                src="{{ asset('storage/images/plays/' . $play->cover_photo) }}"
                                                alt="{{ $play->title }}">
                                        </div>
                                        <div class="p-2 d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column billboard-play-text">
                                                <div>
                                                    <h2 class="fs-4 fw-bold">{{ $play->title }}</h2>
                                                </div>
                                                <div class="ps-3">
                                                    @foreach ($play->schedule_short_slots as $slot)
                                                        <small class="billboard-play-schedule">{{ $slot['day'] }}
                                                            {{ $slot['time'] }}</small>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <a class="d-flex align-items-center justify-content-center rounded billboard-ticket-button"
                                                href="{{ route('obras.show', $play) }}">Entradas</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="p-2">
                    @if ($theater->user === auth()->user())
                        @php
                            $pendingPlays = $theater->plays->where('status', 'pending');
                        @endphp
                        @if ($pendingPlays->count() > 0)
                            <h2 class="fs-4 fw-bold text-center mt-4">
                                Obras esperando revisión
                            </h2>
                            @foreach ($theater->plays as $play)
                                @if ($play->status === 'pending')
                                    <div
                                        class="w-100 d-flex flex-column flex-lg-row align-items-center justify-content-between my-4">
                                        <h4 class="col-12 col-lg-2 mb-2 m-lg-0 text-center">{{ $play->title }}</h4>
                                        <div
                                            class="w-100 row flex-column flex-lg-row align-items-center justify-content-center gap-4">
                                            <form class="col-12 col-lg-2" action="{{ route('obras.check', $play) }}"
                                                method="get">
                                                @csrf
                                                <button type="submit"
                                                    class="w-100 d-flex align-items-center justify-content-center rounded py-2 theater-check-button">Revisar</button>
                                            </form>
                                            <form class="col-12 col-lg-2" action="{{ route('obras.verify', $play) }}"
                                                method="post">
                                                @csrf
                                                <button type="submit" class="w-100 btn btn-success py-2">Aprobar</button>
                                            </form>
                                            <form class="col-12 col-lg-2" action="{{ route('obras.reject', $play) }}"
                                                method="post">
                                                @csrf
                                                <button type="submit" class="w-100 btn btn-danger py-2">Rechazar</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <h2 class="fs-4 fw-bold text-center mt-4">
                                <em>No hay obras pendientes de revisión</em>
                            </h2>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @if ($theater->user === auth()->user())
            <form class="pb-4 d-flex justify-content-center" action="{{ route('teatros.destroy', $theater->id) }}"
                method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit"
                    onclick="return confirm('Estás segurx de querer eliminar {{ $theater->nombre }}?')">Eliminar
                    teatro</button>
            </form>
        @endif
    </section>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@endsection
