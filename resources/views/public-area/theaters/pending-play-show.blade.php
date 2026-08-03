@extends('layouts.app')
@section('content')
    <section class="section-public py-4 flex-grow-1">
        <a class="billboard-detail-back-button" href="{{ route('teatros.show', $play->theater) }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
        </a>

        <img class="mx-auto mt-4 img-fluid" src="{{ upload_asset('images/plays/' . $play->cover_photo) }}"
            alt="{{ $play->title }}">

        <div class="row justify-content-center billboard-detail-copy">
            <div class="row justify-content-around my-4">
                <div class="col-12 col-lg-4 d-flex flex-column align-items-center my-4">
                    <h1 class="billboard-detail-h1">{{ $play->title }}</h1>
                    <small>{{ $play->duration }} minutos</small>
                    <div class="text-center my-4">
                        <p class="m-0">{{ $play->theater->name }}</p>
                        <small class="billboard-detail-theater-address">{{ $play->theater->short_address }}</small>
                    </div>
                    <div class="d-flex gap-4">
                        @foreach ($play->schedule_slots as $slot)
                            <p class="rounded-pill border p-2 billboard-detail-play-schedule">{{ $slot['day'] }}
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
                                    <p><strong>{{ $user->pivot->role }}: </strong>{{ $user->name }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-4 my-4">
                <form action="{{ route('obras.verify', $play) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success">Aprobar</button>
                </form>
                <form action="{{ route('obras.reject', $play) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Rechazar</button>
                </form>
            </div>
        </div>
    </section>
@endsection
