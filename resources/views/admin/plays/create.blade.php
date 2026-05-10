@extends('layouts.app')

@section('content')
<section>
    <h2>Crear Obra (admin)</h2>
    <form action="{{ route('plays.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Título de la obra</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" />
            @error('title')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="desc">Descripción</label>
            <textarea name="desc" id="desc">{{ old('desc') }}</textarea>
            @error('desc')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="image">Imagen a utilizar</label>
            <input type="file" name="image" id="image">
            @error('image')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="theater">Seleccionar teatro</label>
            <select name="theater" id="theater">
                @foreach($theaters as $theater)
                <option value="{{ $theater->id }}" data-capacity="{{ $theater->max_capacity }}">{{ $theater->name }}</option>
                @endforeach
            </select>
            <small id="capacity-value"></small>
            @error('theater')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="ticket_price">Precio de la entrada</label>
            <input type="number" name="ticket_price" id="ticket_price" value="{{ old('ticket_price') }}" />
            @error('ticket_price')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="duration">Duración de la obra (en minutos)</label>
            <input type="number" name="duration" id="duration" value="{{ old('duration') }}" />
            @error('duration')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="staff-search">Integrante de elenco</label>
            <select id="staff-search" name="staff_ids[]" multiple placeholder="Buscá por nombre..." autocomplete="off">
            </select>
            @error('staff-ids')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div id="staff-roles-container">

        </div>
        <div>
            <h4>Agregar Funciones (Performances)</h4>
            
            <div>
                <label for="start-date">Fecha de inicio</label>
                <input type="date" id="start-date" name="start_date" value="{{ old('start_date') }}" />
                @error('start_date')
                <div><small>{{ $message }}</small></div>
                @enderror
            </div>
            
            <div>
                <label for="end-date">Fecha de fin</label>
                <input type="date" id="end-date" name="end_date" value="{{ old('end_date') }}" />
                @error('end_date')
                <div><small>{{ $message }}</small></div>
                @enderror
            </div>
            
            <div>
                <label>Días de la semana</label>
                <div>
                    <label for="day-1">Lunes</label>
                    <input type="checkbox" id="day-1" value="1" />
                    
                    <label for="day-2">Martes</label>
                    <input type="checkbox" id="day-2" value="2" />
                    
                    <label for="day-3">Miércoles</label>
                    <input type="checkbox" id="day-3" value="3" />
                    
                    <label for="day-4">Jueves</label>
                    <input type="checkbox" id="day-4" value="4" />
                    
                    <label for="day-5">Viernes</label>
                    <input type="checkbox" id="day-5" value="5" />
                    
                    <label for="day-6">Sábado</label>
                    <input type="checkbox" id="day-6" value="6" />
                    
                    <label for="day-0">Domingo</label>
                    <input type="checkbox" id="day-0" value="0" />
                </div>
            </div>
            <div id="perf-times-container">
                
            </div>
        </div>
        <div>
            <button type="submit">Crear</button>
        </div>
    </form>

</section>

@endsection