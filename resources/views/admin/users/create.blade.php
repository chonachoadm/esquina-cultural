@extends('layouts.app')

@section('content')
    <section class="section-personal py-4">
        <div class="my-4">
            <a class="billboard-detail-back-button" href="{{ route('users.index') }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>

            <div class="billboard-detail-copy">
                <h1 class="billboard-detail-comment-title">Crear usuario</h1>
                <div class="row justify-content-center">
                    <form
                        class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 my-4 rounded-3xl auth-forms"
                        action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="name">Nombre completo</label>
                            <input class="p-1 rounded auth-form-input" type="text" id="name" name="name"
                                value="{{ old('name') }}" />
                            @error('name')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="email">Correo electrónico</label>
                            <input class="p-1 rounded auth-form-input" type="email" id="email" name="email"
                                value="{{ old('email') }}" />
                            @error('email')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="password">Contraseña</label>
                            <input class="p-1 rounded auth-form-input" type="password" id="password" name="password" />
                            @error('password')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="password_confirmation">Confirmar contraseña</label>
                            <input class="p-1 rounded auth-form-input" type="password" id="password_confirmation"
                                name="password_confirmation" />
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="image">Foto de perfil</label>
                            <input class="p-1 rounded auth-form-input" type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp" data-cropper-aspect="1" data-cropper-width="500" data-cropper-height="500">
                            @error('image')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="bio">Biografía</label>
                            <textarea class="p-1 rounded auth-form-input" type="text" id="bio" name="bio">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <button class="rounded px-1 py-2 billboard-ticket-button" type="submit">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
