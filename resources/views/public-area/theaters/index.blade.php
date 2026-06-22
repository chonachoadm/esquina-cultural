@extends('layouts.app')

@section('content')
<section class="section-public">
    <div class="my-4 billboard-detail-copy">
        <h1 class="billboard-detail-comment-title">Teatros</h1>

        <div class="text-center">
            Buscador
        </div>
            <div class="d-flex flex-column align-items-center w-100">
                @foreach($theaters as $theater)
                <a href="{{ route('teatros.show', $theater->id) }}" class="w-100 text-black text-decoration-none">
                    <div class="rounded-3xl my-2 p-2 billboard-card">
                        <h3 class="fw-bold">{{ $theater->name }}</h3>
                        <p><em>{{ $theater->short_address }}</em></p>
                        @if($theater->user_id !== auth()->id())
                        <small>{{ $theater->user->name }}</small>
                        @else
                        <small>{{ $theater->user->name }} (vos)</small>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>    
</section>
@endsection