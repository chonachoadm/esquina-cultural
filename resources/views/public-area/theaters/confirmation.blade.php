@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('content')

<section class="p-4 d-flex flex-column align-items-center justify-content-center gap-4 section-confirmation">
    <div class="w-100">
        <a href="{{ route('profile') }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/back-white-25.webp') }}" alt="Volver">
        </a>
    </div>
    <h2 class="text-white text-center"><em>¡Felicidades por tu nuevo espacio!</em></h2>
    <div class="row justify-content-center">
        <div class="w-75 mb-4 confirmation-yellow-container">
            <img class="img-fluid" src="{{ asset('storage/images/icons/check-black.webp') }}" alt="Éxito">
        </div>
    </div>
    <div class="d-flex flex-column align-items-center confirmation-warning">
        <p class="text-white">El administrador pronto revisará la petición.</p>
        <p class="text-white">Te avisaremos por correo cuando se verifique la existencia del teatro.</p>
    </div>
</section>
@endsection