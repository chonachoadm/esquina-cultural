@extends('layouts.app')
@section('content')

    <section class="section-personal flex-grow-1">
        <div class="billboard-detail-copy">
            @if (session('message'))
                <div class="mt-4 alert alert-warning">
                    <small>{{ session('message') }}</small>
                </div>
            @elseif(session('success'))
                <div class="mt-4 alert alert-success">
                    <small>{{ session('success') }}</small>
                </div>
            @elseif(session('error'))
                <div class="mt-4 alert alert-danger">
                    <small>{{ session('error') }}</small>
                </div>
            @endif


            <div class="mt-4 d-flex justify-content-center">
                @if (!auth()->user()->profile->image)
                    <p><em>Sin foto de perfil</em></p>
                @else
                    <img class="w-25 img-fluid" src="{{ asset('storage/images/profiles/' . auth()->user()->profile->image) }}"
                        alt="Foto de perfil de {{ auth()->user()->name }}">
                @endif
            </div>


            <div class="row flex-column align-items-center my-2">
                <div class="col-12 col-lg-6 row justify-content-center align-items-center">
                    <h2 class="col-8 col-md-6 p-0 m-0 billboard-detail-comment-title">{{ auth()->user()->name }}</h2>
                    <a class="col-2 settings-icon" href="{{ route('settings') }}">
                        <img class="img img-fluid" src="{{ asset('storage/images/icons/settings-icon.svg') }}"
                            alt="Ajustes">
                    </a>
                </div>
                @if (auth()->user()->theater && auth()->user()->theater->verification_status === 'verified')
                    <small class="text-center my-2"><em>Administrador de </em><a
                            href="{{ route('teatros.show', auth()->user()->theater->id) }}"><strong>{{ auth()->user()->theater->name }}</strong></a></small>
                    <a class="text-center my-2" href="{{ route('tickets.scanner') }}">Escanear entradas</a>
                @elseif(auth()->user()->theater && auth()->user()->theater->verification_status === 'pending')
                    <p class="text-center my-2"><em>Esperando aprobación del registro del teatro</em></p>
                @endif
            </div>

            <div class="row justify-content-center">
                <p class="col-12 col-md-6">{{ auth()->user()->profile->bio }}</p>
            </div>


            <div class="row justify-content-center my-4">
                <div class="col-12 col-md-6">
                    <h3 class="billboard-detail-comment-subtitle">Tickets</h3>
                    <div class="row">
                        @if ($tickets->count() > 0)
                            @foreach ($tickets as $ticket)
                                <a href="{{ route('tickets.show', $ticket) }}"
                                    class="col-12 col-md-8 px-4 py-2 d-flex align-items-center gap-4 my-2 mx-auto text-decoration-none text-black rounded billboard-detail-comment">
                                    <div>
                                        <img src="{{ asset('storage/tickets/qr_' . $ticket->id . '.png') }}"
                                            alt="Código QR">
                                    </div>
                                    <div>
                                        <h4 class="mb-2"><strong>{{ $ticket->performance->play->title }}</strong></h4>
                                        <p class="m-0">
                                            <em>{{ $ticket->performance->start_time->locale('es')->isoFormat('dddd D [de] MMMM - H:mm') }}</em>
                                        </p>
                                        <span
                                            class="badge {{ $ticket->status_badge_class }}">{{ $ticket->status_label }}</span>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <p class="text-center"><em>No tenés tickets adquiridos aún.</em></p>
                        @endif
                    </div>
                </div>
            </div>

            @if (auth()->user()->plays->count() > 0)
                <div class="my-4">
                    <h3 class="billboard-detail-comment-subtitle">Obras</h3>
                    <div class="rounded-3xl p-4 billboard-detail-tech-container">
                        <div>
                            @foreach (auth()->user()->plays as $play)
                                <div class="my-4 profile-play-container">
                                    <h4><a class="link-hover"
                                            href="{{ route('obras.show', $play) }}"><strong>{{ $play->title }}</strong></a>
                                    </h4>
                                    <p><em>{{ $play->pivot->role }}</em></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </section>

@endsection
