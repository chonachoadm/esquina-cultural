@extends('layouts.app')

@section('content')
<section>
    <div>
        <a href="{{ route('teatros.index') }}">Volver</a>
    </div>
    <div class="row">
        <div class="col-md-6 col-12">
            <h2>{{ $theater->name }}</h2>
            <p>{{ $theater->bio }}</p>
            <div>
                <p><em>{{ $theater->address }}</em></p>
            </div>
            <div>
                <h3>Obras en cartelera</h3>
                <ul>
                    @foreach($theater->plays as $play)
                    <li><a href="{{ route('obras.show', $play) }}">{{ $play->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            
        </div>
        <div class="col-md-6 col-12">
            (mapa)
        </div>
    </div>
    @if($theater->user === auth()->user())
    <form action="{{ route('teatros.destroy', $theater->id) }}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit" onclick="return confirm('Estás segurx de querer eliminar {{ $theater->nombre }}?')">Eliminar teatro</button>
    </form>
    @endif
</section>
@endsection