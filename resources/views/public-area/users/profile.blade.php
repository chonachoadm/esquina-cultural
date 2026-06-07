@extends('layouts.app')
@section('content')


<img src="{{ asset('storage/images/profiles/' . $user->profile->image) }}" alt="Foto de perfil de {{ auth()->user()->name }}">
<h2> {{ $user->name }}</h2>

@if($user->theater->verification_status == 'verified')
<small><em>Administrador de </em><strong>{{ $user->theater->name }}</strong></small>
@elseif(auth()->user()->theater && auth()->user()->theater->verification_status === 'pending')
<p><em>Esperando aprobación del registro del teatro</em></p>
@endif

<p>{{ $user->profile->bio }}</p>

@if(auth()->user()->id == $user->id)
<a href="{{ route('public.user.edit', $user) }}">Editar perfil</a>

@if(auth()->user()->theater->verification_status === 'verified')
<a href="">Editar información del teatro</a>
@elseif(!auth()->user()->theater)
<a href="{{ route('teatros.create', $user) }}">Registrar teatro a mi nombre</a>
@endif

<form action="{{ route('public.user.delete', $user) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit">Eliminar cuenta</button>
</form>
@endif

@endsection