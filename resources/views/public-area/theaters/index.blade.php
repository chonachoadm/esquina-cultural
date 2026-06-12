@extends('layouts.app')

@section('content')
<section>
    <div>
        <h2>Teatros</h2>
    </div>
    <div>
        <div class="row d-flex justify-content-center w-100">
            @foreach($theaters as $theater)
            <a href="{{ route('teatros.show', $theater->id) }}" class="text-black text-decoration-none">
                <div class="border m-4 p-2 col-lg-3 col-md-4 col-12">
                    <h3>{{ $theater->name }}</h3>
                    <p><em>{{ $theater->address }}</em></p>
                    <small><strong>{{ $theater->user->name }}</strong></small>
                </div>
            </a>
            @endforeach
        </div>
    </div>    
</section>
@endsection