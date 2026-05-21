@extends('layouts.app')
@section('content')
<h1>Este es el login</h1>

<form action="{{ route('login') }}" method="post">
    @csrf
    <div>
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" />
        @error('email')
        <div><small>{{ $message }}</small></div>
        @enderror  
    </div>
    <div>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" />
    </div>
    <div>
        <button type="submit">Ingresar</button>
    </div>
</form>


@endsection