@extends('layouts.app')

@section('content')
    <section class="section-personal py-4">
        <div class="m-4">
            <h1 class="mb-4">Usuarios</h1>
            <a class="rounded px-4 py-2 btn btn-success" href="{{ route('users.create') }}">Crear usuario</a>
        </div>

        <div class="rounded-3xl p-4 mb-4 table-responsive billboard-detail-copy auth-form-input">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td scope="row">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            @if ($user->role === 1)
                                <td>Administrador</td>
                            @elseif($user->role === 2)
                                <td>Dueño de teatro</td>
                            @else
                                <td>Usuario</td>
                            @endif
                            <td><a class="rounded px-2 py-1 billboard-ticket-button"
                                    href="{{ route('users.show', $user) }}">Ver</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
