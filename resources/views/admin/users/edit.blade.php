@extends('layouts.app')

@section('content')
    <section class="section-personal">
        <div class="my-4">
            <a class="billboard-detail-back-button" href="{{ route('users.show', $user) }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>

            <div class="billboard-detail-copy">
                <h1 class="billboard-detail-comment-title">Editar usuario</h1>
                <div class="row justify-content-center">
                    <form
                        class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 my-4 rounded-3xl auth-forms"
                        action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex flex-column w-100 mb-2">
                            @if ($user->profile->image)
                                <img src="{{ asset('storage/images/profiles/' . $user->profile->image) }}"
                                    alt="Foto de perfil de {{ $user->name }}">
                            @endif
                            <label for="image">Cambiar foto de perfil</label>
                            <input class="p-1 rounded auth-form-input" type="file" name="image" id="image">
                            @error('image')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="name">Nombre completo</label>
                            <input class="p-1 rounded auth-form-input" type="text" id="name" name="name"
                                value="{{ old('name', $user->name) }}" />
                            @error('name')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="email">Correo electrónico</label>
                            <input class="p-1 rounded auth-form-input" type="email" id="email" name="email"
                                value="{{ old('email', $user->email) }}" />
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
                        <div class="w-100 d-flex justify-content-center">
                            <button class="rounded px-1 py-2 billboard-ticket-button" type="submit">Guardar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
