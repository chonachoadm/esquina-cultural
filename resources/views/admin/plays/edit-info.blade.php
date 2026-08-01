@extends('layouts.app')

@section('content')
    <section class="section-personal py-4 flex-grow-1">
        <div class="my-4">
            <a class="billboard-detail-back-button" href="{{ route('plays.show', $play) }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>

            <div class="billboard-detail-copy">
                <h1 class="billboard-detail-comment-title">Editar información - {{ $play->title }}</h1>
                <div class="row justify-content-center">
                    <form
                        class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 my-4 rounded-3xl auth-forms"
                        action="{{ route('plays.update-info', $play) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="title">Título de la obra</label>
                            <input class="p-1 rounded auth-form-input" type="text" id="title" name="title"
                                value="{{ old('title', $play->title) }}" />
                            @error('title')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="desc">Descripción</label>
                            <textarea class="p-1 rounded auth-form-input" name="desc" id="desc">{{ old('desc', $play->description) }}</textarea>
                            @error('desc')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            @if ($play->cover_photo)
                                <img src="{{ asset('storage/images/plays/' . $play->cover_photo) }}"
                                    alt="Banner de {{ $play->title }}">
                            @endif
                            <label for="image">Imagen a utilizar</label>
                            <input class="p-1 rounded auth-form-input" type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp" data-cropper-aspect="1.7778" data-cropper-width="1200" data-cropper-height="675">
                            @error('image')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="theater">Seleccionar teatro</label>
                            <select class="p-1 rounded auth-form-input" name="theater" id="theater">
                                @foreach ($theaters as $theater)
                                    <option value="{{ $theater->id }}"
                                        {{ $play->theater_id == $theater->id ? 'selected' : '' }}
                                        data-capacity="{{ $theater->max_capacity }}">{{ $theater->name }}</option>
                                @endforeach
                            </select>
                            <small id="capacity-value"></small>
                            @error('theater')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="user_id">Usuario creador</label>
                            <select class="p-1 rounded auth-form-input" name="user_id" id="user_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $play->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="ticket_price">Precio de la entrada</label>
                            <input class="p-1 rounded auth-form-input" type="number" name="ticket_price" id="ticket_price"
                                value="{{ old('ticket_price', $play->ticket_price) }}" />
                            @error('ticket_price')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="duration">Duración de la obra (en minutos)</label>
                            <input class="p-1 rounded auth-form-input" type="number" name="duration" id="duration"
                                value="{{ old('duration', $play->duration) }}" />
                            @error('duration')
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
