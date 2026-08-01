@extends('layouts.app')

@section('content')
    <section class="section-personal py-4 flex-grow-1">
        <div class="my-4">
            <a class="billboard-detail-back-button" href="{{ route('plays.show', $play) }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>

            <div class="billboard-detail-copy">
                <h1 class="billboard-detail-comment-title">Editar funciones - {{ $play->title }}</h1>
                <div class="row justify-content-center">
                    <h2 class="text-center mt-4 fs-3">Funciones Actuales</h2>
                    @if ($play->performances->count() > 0)
                        <div class="p-4 rounded-3xl w-50 auth-form-input">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Fecha y horario</th>
                                        <th scope="col">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($play->performances as $performance)
                                        <tr>
                                            <td scope="row">{{ $performance->id }}</td>
                                            <td scope="row">{{ $performance->start_time }}</td>
                                            <td scope="row">
                                                <form action="{{ route('performances.destroy', $performance) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('¿Estás seguro de querer eliminar la función del {{ $performance->start_time }}?')">X</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No hay funciones programadas.</p>
                    @endif
                </div>

                <div class="row justify-content-center">
                    <h2 class="text-center mt-4 fs-3">Agregar Nuevas Funciones</h2>
                    <form
                        class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 px-2 mb-4 rounded-3xl auth-forms"
                        action="{{ route('plays.update-performances', $play) }}" method="POST" id="add-performances-form">
                        @csrf
                        @method('PUT')

                        <div class="d-flex flex-column w-50 mb-2">
                            <label for="perf-date">Fecha</label>
                            <input class="p-1 rounded auth-form-input" type="date" id="perf-date" />
                        </div>

                        <div class="d-flex flex-column w-50 mb-2">
                            <label for="perf-time">Hora</label>
                            <input class="p-1 rounded auth-form-input" type="time" id="perf-time" />
                        </div>

                        <button class="w-50 rounded px-1 py-2 billboard-detail-comment-submit-button" type="button"
                            id="btn-add-performance">Agregar Función</button>

                        <div id="new-performances-list" class="d-none">
                            <h4>Funciones a Agregar</h4>
                            <ul id="performances-to-add">

                            </ul>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <button class="d-none w-50 rounded px-1 py-2 billboard-ticket-button" type="submit"
                                id="btn-submit-performances">Guardar Funciones</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
