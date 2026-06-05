@extends('layouts.app')
@section('content')
<h1>Esta es la cartelera</h1>

<h2>Bienvenidx {{ auth()->user()->name }}</h2>
<ul>
    @foreach($plays as $play)
    <li>
        <a href="{{ route('plays.show', $play) }}">    
            <img src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="{{ $play->title }}">
        </a>
        <div>
            <h3>{{ $play->title }}</h3>
            <p>{{ $play->description }}</p>
        </div>
    </li>
    @endforeach
</ul>

@endsection