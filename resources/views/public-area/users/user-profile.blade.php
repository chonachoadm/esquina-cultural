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
        <div class="mt-4 alert alert-danger">
            <small>{{ session('error') }}</small>
        </div>
        @endif
        

        <div class="mt-4 d-flex justify-content-center">
            @if(!$user->profile->image)
            <p><em>Sin foto de perfil</em></p>
            @else
            <img class="w-25 img-fluid" src="{{ asset('storage/images/profiles/' . $user->profile->image) }}" alt="Foto de perfil de {{ $user->name }}">
            @endif
        </div>


        <div class="row flex-column align-items-center my-2">
            <div class="col-12 col-lg-6 row justify-content-center align-items-center">
                <h2 class="billboard-detail-comment-title">{{ $user->name }}</h2>
            </div>
            @if($user->theater && $user->theater->verification_status === 'verified')
            <small class="text-center my-2"><em>Administrador de </em><a href="{{ route('teatros.show', $user->theater->id) }}"><strong>{{ $user->theater->name }}</strong></a></small>
            @endif
        </div>

        <div class="row justify-content-center">
            <p class="col-12 col-md-6">{{ $user->profile->bio }}</p>
        </div>

        @if($user->plays->count() > 0)
        <div class="my-4">
            <h3 class="billboard-detail-comment-subtitle">Obras</h3>
            <div class="rounded-3xl p-4 billboard-detail-tech-container">
                <div>
                    @foreach($user->plays as $play)
                    <div class="my-4 profile-play-container">
                        <h4><a class="link-hover" href="{{ route('obras.show', $play) }}"><strong>{{ $play->title }}</strong></a></h4>
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