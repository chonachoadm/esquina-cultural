@extends('layouts.app')
@section('content')
<section class="py-5 section-public">

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
    
    <div class="d-flex flex-column align-items-center">
        <h1 class="my-4 billboard-h1">Nuestra cartelera</h1>        
        <div class="mt-4">
            Buscador
        </div>
        <div class="row justify-content-center mx-2 gap-4 my-4">
            @foreach($plays as $play)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mx-1 p-0 rounded-3xl billboard-card">
                <div class="billboard-img-container">
                    <img class="mx-auto img-fluid" src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="{{ $play->title }}">
                </div>
                <div class="d-flex align-items-center justify-content-between px-2 py-1">
                    <div class="billboard-play-text">
                        <div>
                            <h2 class="billboard-play-title">{{ $play->title }}</h2>
                            <p class="m-0">{{ $play->theater->name }}</p>
                            <small class="billboard-theater-address">{{ $play->theater->short_address }}</small>
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
</section>
@endsection