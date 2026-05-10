@extends('layouts.app')

@section('content')
<section>
    <h2>Todos los usuarios (admin)</h2>
    <a href="{{ route('users.create') }}">Crear usuario</a>

    <ul>
        @foreach($users as $user)
        <li>
            <h3>
                {{ $user->name }}
            </h3>
            <p>
                {{ $user->email }}
            </p>
            <a href="{{ route('users.show', $user) }}">Ver</a>
        </li>
        @endforeach
    </ul>
</section>

@endsection