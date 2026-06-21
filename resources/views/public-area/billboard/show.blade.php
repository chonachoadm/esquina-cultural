@extends('layouts.app')
@section('content')

<section class="section-public">
    @if(session('message'))
    <div class="alert alert-warning">
        <small>{{ session('message') }}</small>
    </div>
    @elseif(session('success'))
    <div class="alert alert-success">
        <small>{{ session('success') }}</small>
    </div>
    @elseif(session('error'))
    <div class="alert alert-error">
        <small>{{ session('error') }}</small>
    </div>
    @endif

    <a class="billboard-detail-back-button" href="{{ url()->previous() ?? route('billboard') }}">
        <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
    </a>
    @auth
    <div class="billboard-detail-save-play-button">
        @if(auth()->user()->savedPlays->contains($play->id))
        <form action="{{ route('unsave.play', $play) }}" method="post">
            @csrf
            <button>Quitar de guardados</button>
        </form>
        @else
        <form action="{{ route('save.play', $play) }}" method="post">
            @csrf
            <button type="submit">Guardar</button>
        </form>
        @endif
    </div>
    @endauth

    <img class="img-fluid w-100" src="{{ asset('storage/images/plays/' . $play->cover_photo) }}" alt="{{ $play->title }}">
    
    <div class="billboard-detail-copy">
        <button class="w-100 mt-4 d-flex align-items-center justify-content-center rounded billboard-detail-buy-ticket-button">Comprar entradas</button>
        <div class="d-flex flex-column align-items-center my-4">
            <h1 class="billboard-detail-h1">{{ $play->title }}</h1>
            <small>{{ $play->duration }} minutos</small>
            <div class="text-center my-4">
                <p class="m-0">{{ $play->theater->name }}</p>
                <small class="billboard-detail-theater-address">{{ $play->theater->short_address }}</small>
            </div>
            <div class="d-flex gap-4">
                @foreach($play->schedule_slots as $slot)
                <p class="rounded-pill border p-2 billboard-detail-play-schedule">{{ $slot['day'] }} {{ $slot['time'] }}</p>
                @endforeach
            </div>
            <p><strong>Precio por entrada:</strong> $ {{ $play->ticket_price }}</p>
        </div>
        
        <hr>
        
        <div class="my-4">
            <p>
                {{ $play->description }}
            </p>
            <div class="p-4 rounded-3xl billboard-detail-tech-container">
                <h2 class="text-center billboard-detail-tech-title">Ficha técnica</h2>
                <ul class="list-unstyled">
                    @foreach($play->users as $user)
                    <li><p><strong>{{ $user->pivot->role }}: </strong>{{ $user->name }}</p></li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <hr>
        
        <div>
            @auth
            <h2 class="billboard-detail-comment-title">¡Dejanos tu opinión!</h2>
            <form action="{{ route('comments.store', $play) }}" method="post">
                @csrf
                <div class="d-flex flex-column">
                    <textarea aria-label="Escribí tu comentario acá" name="body" id="body" class="p-2 w-100 rounded-2xl billboard-detail-comment-input" placeholder="Escribí tu comentario acá..."></textarea>
                    <button type="submit" class="align-self-end billboard-detail-comment-submit-button">Enviar</button>
                </div>
            </form>
            @endauth
            @guest
            <h2 class="billboard-detail-comment-title">Chequeá las opiniones de nuestro público!</h2>
            @endguest
            
            @if($play->comments)
            <div class="mt-4">
                @auth
                <h3 class="billboard-detail-comment-subtitle">Otras opiniones</h3>
                @endauth
                <ul class="list-unstyled mt-4">
                    
                    @foreach($play->comments as $comment)
                    <li class="rounded-2xl p-2 my-2 billboard-detail-comment">
                        <div class="d-flex justify-content-between">
                            @if($comment->user)
                            <span class="billboard-detail-comment-owner">{{ $comment->user->name }}</span>
                            @else
                            <span class="billboard-detail-comment-owner"><em>Usuario inexistente</em></span>
                            @endif
                            <small class="billboard-detail-comment-time"><em>{{ $comment->created_at->diffForHumans() }}</em></small>
                        </div>
                        <p class="my-1">{{ $comment->comment_body }}</p>
                        
                        @auth
                        @if($comment->user_id === auth()->user()->id || auth()->user()->isAdmin())
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar este comentario?')" class="text-danger">Eliminar</button>
                        </form>
                        @endif
                        @endauth
                        
                    </li>
                    @endforeach
                    
                </ul>
                @else
                <p><em>No hay comentarios aún.</em></p>
                @endif
            </div>
                
        </div>
    </div>
</section>

@endsection