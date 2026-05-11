@extends('layouts.app')

@section('content')
<section>
    <h2>Editar Usuario (admin)</h2>
    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            @if($user->profile->image)
            <img src="{{ asset('storage/images/profiles/' . $user->profile->image) }}" alt="Foto de perfil de {{ $user->name }}">
            @endif
            <label for="image">Cambiar foto de perfil</label>
            <input type="file" name="image" id="image">
            @error('image')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="name">Nombre completo</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" />
            @error('name')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" />
            @error('email')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="bio">Biografía</label>
            <textarea type="text" id="bio" name="bio">{{ old('bio', $user->profile->bio) }}</textarea>
            @error('bio')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <button type="submit">Guardar</button>
        </div>
    </form>

</section>

@endsection