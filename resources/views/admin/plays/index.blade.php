@extends('layouts.app')

@section('content')
    <section class="section-personal">
        <div class="m-4">
            <h1 class="mb-4">Obras</h1>
            <a class="rounded px-4 py-2 btn btn-success" href="{{ route('plays.create') }}">Crear Obra</a>
        </div>

        <div class="rounded-3xl p-4 mb-4 table-responsive billboard-detail-copy auth-form-input">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Publicante</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plays as $play)
                        <tr>
                            <td scope="row">{{ $play->id }}</td>
                            <td>{{ $play->title }}</td>
                            <td>$ {{ $play->ticket_price }}</td>
                            <td>{{ $play->user->email }}</td>
                            <td>{{ $play->status }}</td>
                            <td><a class="rounded px-2 py-1 billboard-ticket-button"
                                    href="{{ route('plays.show', $play) }}">Ver</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
