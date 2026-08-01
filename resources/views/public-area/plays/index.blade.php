@extends('layouts.app')
@section('content')
    <section class="section-public py-4 flex-grow-1">

        @if (session('message'))
            <div class="alert alert-warning m-4">
                <small>{{ session('message') }}</small>
            </div>
        @elseif(session('success'))
            <div class="alert alert-success m-4">
                <small>{{ session('success') }}</small>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger m-4">
                <small>{{ session('error') }}</small>
            </div>
        @endif

        <div class="d-flex flex-column align-items-center">
            <h1 class="my-4 billboard-h1">Nuestra cartelera</h1>
            <div class="row justify-content-center mx-2 gap-4 my-4">
                @foreach ($plays as $play)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mx-1 p-0 rounded-3xl billboard-card">
                        <div class="billboard-img-container">
                            <a href="{{ route('obras.show', $play) }}"><img class="mx-auto img-fluid"
                                    src="{{ asset('storage/images/plays/' . $play->cover_photo) }}"
                                    alt="{{ $play->title }}"></a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between p-4">
                            <div class="d-flex flex-column justify-content-between billboard-play-text">
                                <div>
                                    <h2 class="billboard-play-title"><a class="link-hover"
                                            href="{{ route('obras.show', $play) }}">{{ $play->title }}</a></h2>
                                    <p class="m-0">{{ $play->theater->name }}</p>
                                    <small class="billboard-theater-address">{{ $play->theater->short_address }}</small>
                                </div>
                                <div class="ps-3">
                                    @foreach ($play->schedule_short_slots as $slot)
                                        <small
                                            class="rounded-pill bg-gray-100 px-2 py-1 billboard-play-schedule">{{ $slot['day'] }}
                                            {{ $slot['time'] }}</small>
                                    @endforeach
                                </div>
                            </div>
                            <a class="d-flex align-items-center justify-content-center rounded billboard-ticket-button"
                                href="{{ route('compra.create', $play) }}">Entradas</a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
