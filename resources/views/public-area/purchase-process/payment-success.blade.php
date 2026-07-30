@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('content')
    <section class="p-4 d-flex flex-column align-items-center justify-content-center gap-4 section-confirmation">
        <div class="w-100">
            <a href="{{ route('billboard') }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-white-25.webp') }}" alt="Volver">
            </a>
        </div>
        <h2 class="text-white text-center"><em>¡Se confirmó tu compra!</em></h2>
        <div class="row justify-content-center">
            <div class="w-75 mb-4 confirmation-yellow-container">
                <img class="img-fluid" src="{{ asset('storage/images/icons/check-black.webp') }}" alt="Éxito">
            </div>
        </div>
        <div class="d-flex flex-column align-items-center confirmation-warning">
            <p class="text-white">Podés encontrar tu entrada en tu perfil.</p>
            <p class="text-white">Gracias por ser parte de <strong>Esquina Cultural</strong>.</p>
        </div>
    </section>
@endsection
