@extends('layouts.app')
@section('content')
<section class="section-public flex-grow-1">
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

    <a class="billboard-detail-back-button" href="{{ route('obras.show', $play) }}">
        <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
    </a>

    <div class="d-flex flex-column justify-content-center my-4 billboard-detail-copy">
        <div class="my-4 text-center">
            <h1 class="fw-bold">
                {{ $play->title }}
            </h1>    
            <div class="mt-2">
                <p class="m-0">{{ $play->theater->name }}</p>
                <small class="billboard-detail-theater-address">{{ $play->theater->short_address }}</small>
            </div>
        </div>
        <hr class="d-block d-lg-none my-2">
        <p class="text-center"><em>Ir al teatro hace bien</em></p>
        <div class="row justify-content-center">
            <form class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 my-4 rounded-3xl" action="{{ route('compra.store', $play) }}" method="POST">
                @csrf
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="name">Nombre</label>
                    <input 
                        class="p-1 rounded auth-form-input" 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ auth()->user()?->name ?? old('name', '') }}" 
                        {{ auth()->check() ? 'readonly' : '' }} />
                    @error('name')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="email">Correo electrónico</label>
                    <input 
                        class="p-1 rounded auth-form-input" 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ auth()->user()?->email ?? old('email', '') }}" 
                        {{ auth()->check() ? 'readonly' : '' }} />
                    @error('email')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="performance">Seleccionar función</label>
                    <select class="p-1 rounded auth-form-input"  name="performance_id" id="performance_id" >
                        @foreach($play->performances as $performance)
                        <option value="{{ $performance->id }}">{{ $performance->start_time->translatedFormat('l d \d\e F - H:i') }}</option>
                        @endforeach
                    </select>
                    @error('performance_id')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="ticket_amount">Cantidad de entradas</label>
                    <input class="p-1 rounded auth-form-input"  type="number" name="ticket_amount" id="ticket_amount">
                    @error('ticket_amount')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <button class="w-100 landing-auth-button" type="submit">Continuar</button>
            </form>
        </div>
    </div>
</section>
@endsection