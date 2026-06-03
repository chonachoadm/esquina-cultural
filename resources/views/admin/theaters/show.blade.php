@extends('layouts.app')

@section('content')
<section>
    <h2>{{ $theater->name }}</h2>
    <small>{{ $theater->address }}</small>
    <p>{{ $theater->bio }}</p>
    <span><strong>Capacidad máxima:</strong> {{ $theater->max_capacity }} lugares</span>
    <span><strong>Administrador:</strong> {{ $theater->user->name }}</span>
    
    <a href="{{ route('theaters.edit', $theater) }}">Editar</a>

    <form action="{{ route('theaters.destroy', $theater) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar {{ $theater->name }}?')">Eliminar</button>
    </form>
</section>

@endsection