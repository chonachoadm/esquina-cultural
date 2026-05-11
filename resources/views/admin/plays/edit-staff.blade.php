@extends('layouts.app')

@section('content')
<section>
    <h2>Modificar Integrantes - {{ $play->title }}</h2>
    <div>
        <h3>Integrantes Actuales</h3>
        @if($play->users->count() > 0)
        <ul id="current-staff-list">
            @foreach($play->users as $user)
            <li data-user-id="{{ $user->id }}">
                <p>{{ $user->name }}</p>
                <small>{{ $user->pivot->role }}</small>
                <button type="button" class="remove-user-btn" data-user-id="{{ $user->id }}">X</button>
            </li>
            @endforeach
        </ul>
        @else
        <p>No hay integrantes asignados.</p>
        @endif
    </div>
    <form action="{{ route('plays.update-staff', $play) }}" method="POST" id="staff-form">
        @csrf
        @method('PUT')
        <div>
            <label for="staff-search">Agregar integrantes</label>
            <select id="staff-search" name="staff_ids[]" multiple placeholder="Buscá por nombre..." autocomplete="off">
            </select>
            @error('staff_ids')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div id="staff-roles-container">

        </div>
        <div>
            <button type="submit">Guardar Integrantes</button>
        </div>
    </form>
</section>
@endsection
