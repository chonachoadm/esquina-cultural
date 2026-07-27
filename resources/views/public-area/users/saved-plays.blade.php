@extends('layouts.app')
@section('content')

<section class="section-personal flex-grow-1">
    <a class="billboard-detail-back-button" href="{{ route('settings') }}">
        <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
    </a>
    <div class="my-4 billboard-detail-copy">
        <h1 class="billboard-detail-comment-title">Obras guardadas</h1>
        <div class="row justify-content-center gap-4 py-4">
            @if(auth()->user()->savedPlays->count() > 0)
            @foreach(auth()->user()->savedPlays as $play)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center justify-content-between p-2 rounded-3xl billboard-card">
                <div class="w-50">
                    <a href="{{ route('obras.show', $play) }}" class="link-hover"><h3 class="fw-bold">{{ $play->title }}</h3></a>
                    <p class="m-0">{{ $play->theater->name }}</p>
                </div>
                <div>
                @if($play->is_finished)
                <span class="saved-plays-inactive">Finalizada</span>
                @else
                <span class="saved-plays-active">En cartelera</span>
                @endif
                </div>
            </div>
            @endforeach
            @else
            <p class="text-center"><em>No tenés obras guardadas aún</em></p>
            @endif
        </div>
    </div>
</section>

@endsection