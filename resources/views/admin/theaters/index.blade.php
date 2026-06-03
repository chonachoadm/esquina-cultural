@extends('layouts.app')

@section('content')
<section>
    <h2>Teatros (admin)</h2>

    <div>
        <a href="{{ route('theaters.create') }}">Registrar nuevo teatro</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Verificación</th>
                    <th>Dueño</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($theaters as $theater)
                <tr>
                    <td>{{ $theater->id }}</td>
                    <td>{{ $theater->name }}</td>
                    <td>{{ $theater->address }}</td>
                    <td>{{ $theater->verification_status }}</td>
                    <td>{{ $theater->user->name }}</td>
                    <td>
                        <a href="{{ route('theaters.show', $theater) }}">Ver</a>
                        <a href="{{ route('theaters.edit', $theater) }}">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection