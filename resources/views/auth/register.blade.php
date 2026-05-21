@extends('layouts.app')
@section('content')

<section>
    <h2>Este es el registro</h2>
    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Nombre completo</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" />
            @error('name')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" />
            @error('email')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" />
            @error('password')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" />
        </div>
        <div>
            <label for="image">Foto de perfil</label>
            <input type="file" name="image" id="image">
            @error('image')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="bio">Biografía</label>
            <textarea type="text" id="bio" name="bio">{{ old('bio') }}</textarea>
            @error('bio')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <button type="submit">Registrarme</button>
        </div>
    </form>

</section>


@endsection