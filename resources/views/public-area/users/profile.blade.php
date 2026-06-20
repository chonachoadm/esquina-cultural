@extends('layouts.app')
@section('content')

<section>
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
    
    @if($user->profile->image === null)
    <p><em>Sin foto de perfil</em></p>
    @else
    <img src="{{ asset('storage/images/profiles/' . $user->profile->image) }}" alt="Foto de perfil de {{ auth()->user()->name }}">
    @endif
    <h2> {{ $user->name }}</h2>


    @if($user->theater && $user->theater->verification_status === 'verified')
    <small><em>Administrador de </em><a href="{{ route('teatros.show', $user->theater->id) }}"><strong>{{ $user->theater->name }}</strong></a></small>
    @elseif(auth()->user()->theater && auth()->user()->theater->verification_status === 'pending')
    <p><em>Esperando aprobación del registro del teatro</em></p>
    @endif

    <p>{{ $user->profile->bio }}</p>

    @if(auth()->user()->id == $user->id)
    <a href="{{ route('public.user.edit', $user) }}">Editar perfil</a>

    @if(auth()->user()->theater && auth()->user()->theater->verification_status === 'verified')
    <a href="{{ route('teatros.edit', $user->theater->id) }}">Editar información del teatro</a>
    @elseif(!auth()->user()->theater)
    <a href="{{ route('teatros.create') }}">Registrar teatro a mi nombre</a>
    @endif

    @if($savedPlays->count() > 0)
    <div>
        <h5><em>Guardados</em></h5>
        <ul>
            @foreach($savedPlays as $play)
            <li><a href="{{ route('obras.show', $play->id) }}">{{ $play->title }}</a></li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('public.user.delete', $user) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar cuenta</button>
    </form>
    @endif
</section>

@endsection