@extends('layouts.app')

@section('content')
<section>
    <h2>Todas las obras (admin)</h2>
    <a href="{{ route('plays.create') }}">Crear Obra</a>
    <ul>
        @foreach($plays as $play)
        <li>
            <img src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="Banner de {{ $play->title }}">
            <h3>{{ $play->title }}</h3>
            <p>$ {{ $play->ticket_price }}</p>
            <p>$ {{ $play->duration }} minutos</p>
            <a href="{{ route('plays.show', $play) }}">Ver</a>
        </li>
        @endforeach
    </ul>
</section>

@endsection