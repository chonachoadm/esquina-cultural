@extends('layouts.app')

@section('content')
    <section class="section-personal py-4 flex-grow-1">
        <div class="my-4">
            <a class="billboard-detail-back-button" href="{{ route('plays.show', $play) }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>
            <div class="billboard-detail-copy">
                <h1 class="billboard-detail-comment-title">Editar integrantes - {{ $play->title }}</h1>
                <div class="row justify-content-center">
                    <form
                        class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 px-2 my-4 rounded-3xl auth-forms"
                        action="{{ route('plays.update-staff', $play) }}" method="POST" id="staff-form">
                        @csrf
                        @method('PUT')
                        <div>
                            <h2>Integrantes Actuales</h2>
                            @if ($play->users->count() > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Rol cumplido</th>
                                            <th scope="col">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($play->users as $user)
                                            <tr data-user-id="{{ $user->id }}">
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->pivot->role }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="text-danger remove-user-btn"
                                                        data-user-id="{{ $user->id }}">X</button>

                                                    <input type="hidden" name="staff_ids[]" value="{{ $user->id }}">
                                                    <input type="hidden" name="staff_roles[{{ $user->id }}]"
                                                        value="{{ $user->pivot->role }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No hay integrantes asignados.</p>
                            @endif
                        </div>

                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="staff-search">Agregar integrantes</label>
                            <select class="p-1 rounded auth-form-input" id="staff-search" name="new_staff_ids[]" multiple
                                placeholder="Buscá por nombre..." autocomplete="off">
                            </select>
                            @error('staff_ids')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div id="staff-roles-container">

                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <button class="w-50 rounded px-1 py-2 billboard-ticket-button" type="submit">Guardar
                                Integrantes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
