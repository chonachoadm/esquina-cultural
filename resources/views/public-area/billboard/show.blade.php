@extends('layouts.app')
@section('content')


<a href="{{ route('billboard') }}">Volver</a>
<h2>Página de {{ $play->title }}</h2>

    <img src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="{{ $play->title }}">
    <div>
        <h3>{{ $play->title }}</h3>
        <p>{{ $play->description }}</p>
    </div>
    <div>
        <small>{{ $play->duration }} minutos</small>
    </div>
    <div>
        <h4>Integrantes</h4>
        <ul>
        @foreach($play->users as $user)
            <li><p>{{ $user->name }} <em>{{ $user->pivot->role }}</em></p></li>
        @endforeach
        </ul>
    </div>
    <div>
        <h5>Comentarios</h5>
        @if($play->comments->isNotEmpty())
        <ul>
            @foreach($play->comments as $comment)
            <li>
                <h6>{{ $comment->user->name }}</h6>
                <small><em>{{ $comment->created_at->diffForHumans() }}</em></small>
                <p>{{ $comment->comment_body }}</p>
                @if($comment->user_id === auth()->user()->id)
                
                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar este comentario?')" class="text-danger">Eliminar</button>
                </form>
                @endif
            </li>
            @endforeach
        </ul>
        @else
        <p><em>No hay comentarios aún.</em></p>
        @endif
        <form action="{{ route('comments.store', $play) }}" method="post" class="w-50">
            @csrf
            <div>
                <label for="body" class="form-label">¡Contanos qué te pareció la obra!</label>
                <textarea name="body" id="body" class="form-control"></textarea>
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>

@endsection