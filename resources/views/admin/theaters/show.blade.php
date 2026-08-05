@extends('layouts.app')
@section('content')


    <section class="section-personal py-4">

        @if (session('message'))
            <div class="alert alert-warning">
                <small class="mx-4">{{ session('message') }}</small>
            </div>
        @elseif(session('success'))
            <div class="w-50 mx-auto alert alert-success mt-4">
                <small class="mx-4">{{ session('success') }}</small>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                <small class="mx-4">{{ session('error') }}</small>
            </div>
        @endif


        <a class="billboard-detail-back-button" href="{{ route('theaters.index') }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
        </a>

        <div class="my-4 d-flex align-items-center justify-content-center">
            <div class="my-4 rounded-3xl billboard-detail-copy billboard-card">
                <div class="container-img-theater">
                    @if(!$theater->image)
                        <p class="text-center mt-4"><em>Sin foto de portada</em></p>
                    @else
                        <img class="w-100 img img-fluid" src="{{ upload_asset('images/theaters/' . $theater->image) }}"
                            alt="Banner de {{ $theater->name }}">
                    @endif
                </div>
                <div class="my-4 p-2">
                    <div class="row justify-content-center align-items-center mb-4">
                        <h1 class="col-12 col-md-4 text-center fw-bold">{{ $theater->name }}</h1>

                        @if ($theater->verification_status === 'verified')
                            <div class="col-12 col-md-4 d-flex justify-content-center gap-2">
                                <a class="btn btn-primary" href="{{ route('theaters.edit', $theater) }}">Editar</a>
                                <form action="{{ route('theaters.destroy', $theater) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit"
                                        onclick="return confirm('¿Estás seguro de querer eliminar {{ $theater->name }}?')">Eliminar</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <p class="text-center">{{ $theater->bio }}</p>
                    @if ($theater->verification_status === 'pending')
                        <div class="d-flex justify-content-center gap-4">
                            <form action="{{ route('theaters.verify', $theater) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Aprobar</button>
                            </form>
                            <form action="{{ route('theaters.reject', $theater) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Rechazar</button>
                            </form>
                        </div>
                    @endif
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
                                            <a href="{{ route('obras.show', $play) }}"><img class="mx-auto img-fluid"
                                                    src="{{ upload_asset('images/plays/' . $play->cover_photo) }}"
                                                    alt="{{ $play->title }}"></a>
                                        </div>
                                        <div class="p-4 d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column billboard-play-text">
                                                <div>
                                                    <h2 class="fs-4 fw-bold"><a class="link-hover"
                                                            href="{{ route('obras.show', $play) }}">{{ $play->title }}</a></h2>
                                                </div>
                                                <div class="ps-3">
                                                    @foreach ($play->schedule_short_slots as $slot)
                                                        <small class="billboard-play-schedule">{{ $slot['day'] }}
                                                            {{ $slot['time'] }}</small>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <a class="d-flex align-items-center justify-content-center rounded billboard-ticket-button"
                                                href="{{ route('compra.create', $play) }}">Entradas</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@endsection