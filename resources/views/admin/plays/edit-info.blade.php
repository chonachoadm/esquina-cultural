@extends('layouts.app')

@section('content')
<section>
    <h2>Modificar Información de la Obra</h2>
    <form action="{{ route('plays.update-info', $play) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Título de la obra</label>
            <input type="text" id="title" name="title" value="{{ old('title', $play->title) }}" />
            @error('title')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="desc">Descripción</label>
            <textarea name="desc" id="desc">{{ old('desc', $play->description) }}</textarea>
            @error('desc')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            @if($play->cover_photo)
            <img src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="Banner de {{ $play->title }}">
            @endif
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
                <option value="{{ $theater->id }}" {{ $play->theater_id == $theater->id ? 'selected' : '' }} data-capacity="{{ $theater->max_capacity }}">{{ $theater->name }}</option>
                @endforeach
            </select>
            <small id="capacity-value"></small>
            @error('theater')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="ticket_price">Precio de la entrada</label>
            <input type="number" name="ticket_price" id="ticket_price" value="{{ old('ticket_price', $play->ticket_price) }}" />
            @error('ticket_price')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="duration">Duración de la obra (en minutos)</label>
            <input type="number" name="duration" id="duration" value="{{ old('duration', $play->duration) }}" />
            @error('duration')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <button type="submit">Guardar</button>
        </div>
    </form>
</section>

@endsection
