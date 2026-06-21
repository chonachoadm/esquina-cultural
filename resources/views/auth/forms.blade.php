@extends('layouts.app')
@section('content')
<section class="section-personal py-4">

    <div class="my-4 billboard-detail-copy">
        <h2 class=" my-4 billboard-detail-comment-title">Ingresá a tu cuenta</h2>
        
        <div class="d-flex flex-column align-items-center gap-4 py-4 rounded-3xl auth-forms">
            <div role="tablist" class="w-100 d-flex justify-content-around">
                <button type="button" id="login-tab" class="w-50 auth-form-tab active-form">Iniciar sesión</button>
                <button type="button" id="register-tab" class="w-50 auth-form-tab">Crear cuenta</button>
            </div>
            
            <form class="w-100 px-4" id="login-form" action="{{ route('login') }}" method="post">
                @csrf
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="email">Correo electrónico</label>
                    <input class="rounded auth-form-input" type="email" id="login-email" name="email" value="{{ old('email') }}" />
                    @error('email')
                    <div><small>{{ $message }}</small></div>
                    @enderror  
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="password">Contraseña</label>
                    <input class="rounded auth-form-input" type="password" name="password" id="login-password" />
                </div>
                <div>
                    <button class="w-100 landing-auth-button" type="submit">Ingresar</button>
                </div>
            </form>
            
            <form class="w-100 px-4" id="register-form" hidden action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="name">Nombre completo</label>
                    <input class="rounded auth-form-input" type="text" id="name" name="name" value="{{ old('name') }}" />
                    @error('name')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="email">Correo electrónico</label>
                    <input class="rounded auth-form-input" type="email" id="register-email" name="email" value="{{ old('email') }}" />
                    @error('email')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="password">Contraseña</label>
                    <input class="rounded auth-form-input" type="password" id="register-password" name="password" />
                    @error('password')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input class="rounded auth-form-input" type="password" id="password_confirmation" name="password_confirmation" />
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="image">Foto de perfil</label>
                    <input class="rounded auth-form-image-input" type="file" name="image" id="image">
                    @error('image')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-4">
                    <label for="bio">Biografía</label>
                    <textarea class="rounded auth-form-input" type="text" id="bio" name="bio">{{ old('bio') }}</textarea>
                    @error('bio')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div>
                    <button class="w-100 landing-auth-button" type="submit">Registrarme</button>
                </div>
            </form>
        </div>
        
    </div>
</section>
    
    
    @endsection