@extends('layouts.app')
@section('content')

<section class="section-personal flex-grow-1">
    <div class="billboard-detail-copy">
        @if(session('message'))
        <div class="mt-4 alert alert-warning">
            <small>{{ session('message') }}</small>
        </div>
        @elseif(session('success'))
        <div class="mt-4 alert alert-success">
            <small>{{ session('success') }}</small>
        </div>
        @elseif(session('error'))
        <div class="mt-4 alert alert-error">
            <small>{{ session('error') }}</small>
        </div>
        @endif
        

        <div class="mt-4 d-flex justify-content-center">
            @if($user->profile->image === null)
            <p><em>Sin foto de perfil</em></p>
            @else
            <img class="w-25 img-fluid" src="{{ asset('storage/images/profiles/' . $user->profile->image) }}" alt="Foto de perfil de {{ auth()->user()->name }}">
            @endif
        </div>


        <div class="d-flex flex-column align-items-center my-2">
            <h2 class="billboard-detail-comment-title">{{ $user->name }}</h2>
            @if($user->theater && $user->theater->verification_status === 'verified')
            <small><em>Administrador de </em><a href="{{ route('teatros.show', $user->theater->id) }}"><strong>{{ $user->theater->name }}</strong></a></small>
            @elseif(auth()->user()->theater && auth()->user()->theater->verification_status === 'pending')
            <p><em>Esperando aprobación del registro del teatro</em></p>
            @endif
        </div>

        <div class="row justify-content-center">
            <p class="col-12 col-md-6">{{ $user->profile->bio }}</p>
        </div>


        <div class="row justify-content-center my-4">
            <div class="col-12 col-md-6">
                <h3 class="billboard-detail-comment-subtitle">Tickets</h3>
                <div>
                    <p class="text-center"><em>No tenés tickets adquiridos aún.</em></p>
                </div>
            </div>
        </div>

        @if(auth()->user()->plays->count() > 0)
        <div class="my-4">
            <h3 class="billboard-detail-comment-subtitle">Obras</h3>
            <div class="rounded-3xl p-4 billboard-detail-tech-container">
                <div>
                    @foreach(auth()->user()->plays as $play)
                    <div class="my-4 profile-play-container">
                        <h4><strong>{{ $play->title }}</strong></h4>
                        <p><em>{{ $play->pivot->role }}</em></p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-center">
            <a href="{{ route('settings') }}">Ajustes</a>
        </div>

    </div>

</section>

@endsection