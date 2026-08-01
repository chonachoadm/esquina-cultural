@extends('layouts.app')

@section('content')
    <section class="section-personal flex-grow-1">
        <div class="my-4">
            <a class="billboard-detail-back-button" href="{{ route('plays.index') }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>

            <div class="billboard-detail-copy">
                <h1 class="billboard-detail-comment-title">Crear Obra</h1>
                <div class="row justify-content-center">
                    <form
                        class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 my-4 rounded-3xl auth-forms"
                        action="{{ route('plays.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="title">Título de la obra</label>
                            <input class="p-1 rounded auth-form-input" type="text" id="title" name="title"
                                value="{{ old('title') }}" />
                            @error('title')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="desc">Descripción</label>
                            <textarea class="p-1 rounded auth-form-input" name="desc" id="desc">{{ old('desc') }}</textarea>
                            @error('desc')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
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
                                    <option value="{{ $theater->id }}" data-capacity="{{ $theater->max_capacity }}">
                                        {{ $theater->name }}</option>
                                @endforeach
                            </select>
                            <small id="capacity-value"></small>
                            @error('theater')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="ticket_price">Precio de la entrada</label>
                            <input class="p-1 rounded auth-form-input" type="number" name="ticket_price" id="ticket_price"
                                value="{{ old('ticket_price') }}" />
                            @error('ticket_price')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="duration">Duración de la obra (en minutos)</label>
                            <input class="p-1 rounded auth-form-input" type="number" name="duration" id="duration"
                                value="{{ old('duration') }}" />
                            @error('duration')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="staff-search">Integrante de elenco</label>
                            <select class="p-1 rounded auth-form-input" id="staff-search" name="staff_ids[]" multiple
                                placeholder="Buscá por nombre..." autocomplete="off">
                            </select>
                            @error('staff-ids')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div id="staff-roles-container">

                        </div>
                        <div>
                            <h3>Funciones</h3>
                            <div class="d-flex flex-column w-100 mb-2">
                                <label for="season">Duración de la temporada</label>

                                <input type="text" id="season" class="p-1 rounded auth-form-input"
                                    placeholder="Seleccioná las fechas" />

                                <input type="hidden" name="start_date" id="start_date">
                                <input type="hidden" name="end_date" id="end_date">

                                @error('start_date')
                                    <div><small class="text-danger">{{ $message }}</small></div>
                                @enderror

                                @error('end_date')
                                    <div><small class="text-danger">{{ $message }}</small></div>
                                @enderror
                            </div>

                            <div class="d-flex flex-column w-100 mb-2 mt-4">
                                <h4 class="fs-5"><strong>Seleccioná los días y horarios de las funciones</strong></h4>
                                <div class="d-flex flex-column justify-content-center gap-2">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row-reverse justify-content-end gap-2">
                                            <label for="day-1">Lunes</label>
                                            <input type="checkbox" id="day-1" value="1" />
                                        </div>

                                        <div id="times_1"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row-reverse justify-content-end gap-2">
                                            <label for="day-2">Martes</label>
                                            <input type="checkbox" id="day-2" value="2" />
                                        </div>

                                        <div id="times_2"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row-reverse justify-content-end gap-2">
                                            <label for="day-3">Miércoles</label>
                                            <input type="checkbox" id="day-3" value="3" />
                                        </div>

                                        <div id="times_3"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row-reverse justify-content-end gap-2">
                                            <label for="day-4">Jueves</label>
                                            <input type="checkbox" id="day-4" value="4" />
                                        </div>

                                        <div id="times_4"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row-reverse justify-content-end gap-2">
                                            <label for="day-5">Viernes</label>
                                            <input type="checkbox" id="day-5" value="5" />
                                        </div>

                                        <div id="times_5"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row-reverse justify-content-end gap-2">
                                            <label for="day-6">Sábado</label>
                                            <input type="checkbox" id="day-6" value="6" />
                                        </div>

                                        <div id="times_6"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row-reverse justify-content-end gap-2">
                                            <label for="day-0">Domingo</label>
                                            <input type="checkbox" id="day-0" value="0" />
                                        </div>

                                        <div id="times_0"></div>
                                    </div>
                                </div>
                            </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#season", {
            mode: "range",
            dateFormat: "d/m/Y",

            onChange: function(selectedDates) {

                if (selectedDates.length === 2) {

                    document.getElementById('start_date').value =
                        selectedDates[0].toISOString().split('T')[0];

                    document.getElementById('end_date').value =
                        selectedDates[1].toISOString().split('T')[0];
                }
            }
        });
    })
</script>
