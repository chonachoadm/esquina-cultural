@extends('layouts.app')

@section('content')
    <section class="section-personal py-4">
        <div class="m-4">
            <h1 class="mb-4">Teatros</h1>
            <a class="rounded px-4 py-2 btn btn-success" href="{{ route('theaters.create') }}">Registrar nuevo teatro</a>
        </div>

        <div class="rounded-3xl p-4 mb-4 table-responsive billboard-detail-copy auth-form-input">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Verificación</th>
                        <th scope="col">Dueño</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($theaters as $theater)
                        <tr>
                            <td scope="row">{{ $theater->id }}</td>
                            <td>{{ $theater->name }}</td>
                            <td>{{ $theater->short_address }}</td>
                            <td>{{ $theater->verification_status }}</td>
                            <td>{{ $theater->user->name }}</td>
                            <td>
                                <a class="rounded px-2 py-1 billboard-ticket-button"
                                    href="{{ route('theaters.show', $theater) }}">Ver</a>
                                <a class="rounded px-2 py-1 btn btn-primary"
                                    href="{{ route('theaters.edit', $theater) }}">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
