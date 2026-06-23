@extends('layouts.app')
@section('content')

<section class="billboard-detail-copy">
    <div class="row flex-column justify-content-center align-items-center settings-list-container">
        <div class="col-12 col-md-6">

                <a class="billboard-detail-back-button" href="{{ route('teatros.index') }}">
                    <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
                </a>

            <ul class="list-unstyled m-0">
                <li class="mb-4">
                    <a class="text-black text-decoration-none" href="{{ route('public.user.edit', auth()->user()) }}">Editar perfil</a>
                </li>
                <li class="mb-4">
                    <a class="text-black text-decoration-none" href="">Cambiar contraseña</a>
                </li>
                @if(auth()->user()->theater)
                <li class="mb-4">
                    <a class="text-black text-decoration-none" href="{{ auth()->user()->theater->verification_status === 'verified' ? route('teatros.show', auth()->user()->theater) : route('teatros.index') }}">Mi teatro</a>
                </li>
                @else
                <li class="mb-4">
                    <a class="text-black text-decoration-none" href="{{ route('teatros.create') }}">Registrar teatro a mi nombre</a>
                </li>
                @endif
                <li class="mb-4">
                    <a class="text-black text-decoration-none" href="">Publicar una obra</a>
                </li>
                <li class="mb-4">
                    <a class="text-black text-decoration-none" href="{{ route('showSavedPlays', auth()->user()) }}">Obras guardadas</a>
                </li>
                <li>
                    <a class="text-black text-decoration-none" href="">Reportar un problema</a>
                </li>
            </ul>
            <hr class="my-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-danger" type="submit">Cerrar sesión</button>
            </form>
            <div class="d-flex justify-content-center mt-4 settings-delete-account-form">
                <form action="{{ route('public.user.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-danger" type="submit" onclick="return confirm('Estás seguro de querer eliminar tu cuenta?')"><strong>Eliminar cuenta</strong></button>
                </form>
            </div>
        </div>
    </div>
</section>
    
    @endsection