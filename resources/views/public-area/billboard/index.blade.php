@extends('layouts.app')
@section('content')

@if(session('error'))
<div>
    <small>{{ session('error') }}</small>
</div>
@endif
<h1>Esta es la cartelera</h1>

@if(auth()->user())
<h2>Bienvenidx {{ auth()->user()->name }}</h2>
@endif
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