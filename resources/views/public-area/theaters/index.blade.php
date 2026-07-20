@extends('layouts.app')

@section('content')
<section class="section-public flex-grow-1">
    <div class="my-4 billboard-detail-copy">
        <h1 class="billboard-detail-comment-title">Teatros</h1>

        <!-- <div class="text-center">
            Buscador
        </div> -->
        <div class="row justify-content-center mb-4">
            @foreach($theaters as $theater)
            <a href="{{ route('teatros.show', $theater->id) }}" class="col-12 col-md-6 col-lg-4 text-black text-decoration-none">
                <div class="rounded-3xl my-2 p-2 billboard-card">
                    <h2 class="fw-bold">{{ $theater->name }}</h2>
                    <p><em>{{ $theater->short_address }}</em></p>
                    @if($theater->user_id !== auth()->id())
                    <small>{{ $theater->user->name }}</small>
                    @else
                    <small>{{ $theater->user->name }} <em>(vos)</em></small>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>    
</section>
@endsection