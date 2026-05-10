@extends('layouts.app')

@section('content')
<section>
    <img src="{{ asset('storage/images/profiles/' . $user->profile->image) }}" alt="Avatar de usuario">
    <h2>{{ $user->name }}</h2>
    <small>{{ $user->email }}</small>

    <div>
        <p>
            {{ $user->profile->bio }}
        </p>
    </div>
    <a href="{{ route('users.edit', $user) }}">Editar</a>

    <form action="{{ route('users.destroy', $user) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar {{ $user->name }}?')">Eliminar</button>
    </form>
</section>

@endsection