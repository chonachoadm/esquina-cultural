@extends('layouts.app')

@section('content')
<section>
    <img src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="Banner de {{ $play->title }}">
    <h2>{{ $play->title }}</h2>
    <p>{{ $play->description }}</p>

    <div>
        <h4>
            {{ $play->theater->name }}
        </h4>
        <p>{{ $play->theater->address }}</p>
    </div>
    <div>
        <h5>Próximas Funciones</h5>
        <select name="performance" id="performance">
            @foreach($play->performances as $performance)
            <option value="{{ $performance->id }}">{{ $performance->start_time }}</option>
            @endforeach
        </select>
        <small> $ {{ $play->ticket_price }}</small>
    </div>
    <form action="{{ route('plays.destroy', $play) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar {{ $play->title }}?')">Eliminar</button>
    </form>

</section>

@endsection