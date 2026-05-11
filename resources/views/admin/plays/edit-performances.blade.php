@extends('layouts.app')

@section('content')
<section>
    <h2>Modificar Funciones (Performances) {{ $play->title }}</h2>
    
    <div>
        <h3>Funciones Actuales</h3>
        @if($play->performances->count() > 0)
        <ul>
            @foreach($play->performances as $performance)
            <li>
                <p>{{ $performance->start_time }}</p>
                <form action="{{ route('performances.destroy', $performance) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar la función del {{ $performance->start_time }}?')">X</button>
                </form>
            </li>
            @endforeach
        </ul>
        @else
        <p>No hay funciones programadas.</p>
        @endif
    </div>

    <div>
        <h3>Agregar Nuevas Funciones</h3>
        <form action="{{ route('plays.update-performances', $play) }}" method="POST" id="add-performances-form">
            @csrf
            @method('PUT')
            
            <div>
                <label for="perf-date">Fecha</label>
                <input type="date" id="perf-date" />
            </div>
            
            <div>
                <label for="perf-time">Hora</label>
                <input type="time" id="perf-time" />
            </div>
            
            <button type="button" id="btn-add-performance">Agregar Función</button>
            
            <div id="new-performances-list" style="display:none;">
                <h4>Funciones a Agregar</h4>
                <ul id="performances-to-add">

                </ul>
            </div>
            <div>
                <button type="submit" id="btn-submit-performances" style="display:none;">Guardar Funciones</button>
            </div>
        </form>
    </div>
</section>

@endsection
