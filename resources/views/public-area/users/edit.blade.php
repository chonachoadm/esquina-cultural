@extends('layouts.app')

@section('content')
<section class="section-personal flex-grow-1">
    <a class="billboard-detail-back-button" href="{{ route('settings') }}">
        <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
    </a>
    <div class="row justify-content-center billboard-detail-copy">
        <form class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 my-4 rounded-3xl auth-forms" action="{{ route('public.user.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if($user->profile->image)
            <img class="w-25" src="{{ asset('storage/images/profiles/' . $user->profile->image) }}" alt="Foto de perfil de {{ $user->name }}">
            @endif
            <div class="d-flex flex-column w-100 mb-2">
                @if($user->profile->image)
                @endif
                <label for="image">Cambiar foto de perfil (tocar debajo)</label>
                <input class="p-1 rounded auth-form-image-input" type="file" name="image" id="image">
                @error('image')
                <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="d-flex flex-column w-100 mb-2">
                <label for="name">Nombre completo</label>
                <input class="p-1 rounded auth-form-input" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" />
                @error('name')
                <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <div class="d-flex flex-column w-100 mb-2">
                <label for="email">Correo electrónico</label>
                <input class="p-1 rounded auth-form-input" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" />
            @error('email')
            <div><small class="text-danger">{{ $message }}</small></div>
            @enderror
            </div>
            <div class="d-flex flex-column w-100 mb-2">
                <label for="bio">Biografía</label>
                <textarea class="p-1 rounded auth-form-input" type="text" id="bio" name="bio">{{ old('bio', $user->profile->bio) }}</textarea>
                @error('bio')
                <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
            <button class="w-100 landing-auth-button" type="submit">Guardar</button>
        </form>
    </div>
</section>

@endsection