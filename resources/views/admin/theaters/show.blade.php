@extends('layouts.app')
@section('content')

<section>
    <a href="{{ route('theaters.index') }}">Volver</a>
    <h2>{{ $theater->name }}</h2>
    <small>{{ $theater->address }}</small>
    <p>{{ $theater->bio }}</p>
    <span><strong>Capacidad máxima:</strong> {{ $theater->max_capacity }} lugares</span>
    <span><strong>Administrador:</strong> {{ $theater->user->name }}</span>

    @if($theater->verification_status === 'verified')
    <a href="{{ route('theaters.edit', $theater) }}">Editar</a>

    <form action="{{ route('theaters.destroy', $theater) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar {{ $theater->name }}?')">Eliminar</button>
    </form>
    @elseif($theater->verification_status === 'pending')
    <form action="{{ route('theaters.verify', $theater) }}" method="post">
        @csrf
        <button type="submit" class="btn btn-success">Aprobar</button>
    </form>
    <form action="{{ route('theaters.reject', $theater) }}" method="post">
        @csrf
        <button type="submit" class="btn btn-danger">Rechazar</button>
    </form>
    @endif
</section>

@endsection