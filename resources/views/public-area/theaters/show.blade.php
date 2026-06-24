@extends('layouts.app')

@section('content')
<section class="section-public flex-grow-1">

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

    <a class="billboard-detail-back-button" href="{{ route('teatros.index') }}">
        <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
    </a>
    @auth
    <div>
        @if($theater->user_id === auth()->id())
        <a class="billboard-detail-save-play-button" href="{{ route('teatros.edit', $theater->id) }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/edit-icon-25.webp') }}" alt="Editar teatro">
        </a>
        @endif
    </div>
    @endauth

    <div class="my-4 d-flex align-items-center justify-content-center">
        <div class="my-4 rounded-3xl p-2 billboard-detail-copy billboard-card">
            <div class="my-4">
                <h1 class="text-center fw-bold">{{ $theater->name }}</h1>
                <p class="text-center">{{ $theater->bio }}</p>
            </div>
            <div class="row flex-column align-items-center py-4">
                <small class="fst-italic text-center">{{ $theater->short_address }}</small>
                <div id="map-view" class="col-12 col-md-6"></div>

                <input type="hidden" id="lat" value="{{ $theater->latitude }}">
                <input type="hidden" id="lng" value="{{ $theater->longitude }}">
            </div>

            <div>
                <h2 class="fs-4 fw-bold text-center mt-4">
                    Obras encartelera
                </h2>
                <div class="row justify-content-center">
                    @foreach($theater->plays as $play)
                    <div class="col-11 col-sm-6 col-md-4 col-lg-3 m-4 p-0 rounded-3xl billboard-card">
                        <div class="billboard-img-container">
                            <img class="img-fluid" src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="{{ $play->title }}">
                        </div>
                        <div class="p-2 d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column billboard-play-text">
                                <div>
                                    <h2 class="fs-4 fw-bold">{{ $play->title }}</h2>
                                </div>
                                <div class="ps-3">
                                    @foreach($play->schedule_short_slots as $slot)
                                    <small class="billboard-play-schedule">{{ $slot['day'] }} {{ $slot['time'] }}</small>
                                    @endforeach
                                </div>
                            </div>
                            <a class="d-flex align-items-center justify-content-center rounded billboard-ticket-button" href="{{ route('obras.show', $play) }}">Entradas</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    @if($theater->user === auth()->user())
    <form action="{{ route('teatros.destroy', $theater->id) }}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" onclick="return confirm('Estás segurx de querer eliminar {{ $theater->nombre }}?')">Eliminar teatro</button>
    </form>
    @endif
</section>

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@endsection