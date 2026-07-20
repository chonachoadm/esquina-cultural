@extends('layouts.app')

@section('content')
<section>
    <h2>Todas las obras (admin)</h2>
    <a href="{{ route('plays.create') }}">Crear Obra</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Duracion</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plays as $play)
            <tr>
                <td>{{ $play->id }}</td>
                <td>{{ $play->title }}</td>
                <td>$ {{ $play->ticket_price }}</td>
                <td>{{ $play->duration }}</td>
                <td>{{ $play->status }}</td>
                <td><a href="{{ route('plays.show', $play) }}">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

@endsection