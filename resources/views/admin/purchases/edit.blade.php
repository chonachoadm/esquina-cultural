@extends('layouts.app')

@section('content')
    <section class="section-personal flex-grow-1">
        <div class="my-4">
            <a class="billboard-detail-back-button" href="{{ route('purchases.index') }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>

            <div class="billboard-detail-copy">
                <h1 class="billboard-detail-comment-title">Editar Compra Nro. {{ $purchase->id }}</h1>
                <div class="row justify-content-center">
                    <form
                        class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center gap-4 p-4 my-4 rounded-3xl auth-forms"
                        action="{{ route('purchases.update', $purchase) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @if ($purchase->user)
                            <div class="d-flex flex-column w-100 mb-2">
                                <label for="user_id">Seleccionar usuario</label>
                                <select class="p-1 rounded auth-form-input" name="user_id" id="user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $purchase->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name ? $user->name : $user->email }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div><small class="text-danger">{{ $message }}</small></div>
                                @enderror
                            </div>
                        @elseif($purchase->guest)
                            <div class="d-flex flex-column w-100 mb-2">
                                <label for="name">Nombre</label>
                                <input class="p-1 rounded auth-form-input" type="text" name="name" id="name"
                                    value="{{ $purchase->guest->name ?? old('name', '') }}" />
                                @error('name')
                                    <div><small class="text-danger">{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="d-flex flex-column w-100 mb-2">
                                <label for="email">Correo electrónico</label>
                                <input class="p-1 rounded auth-form-input" type="email" name="email" id="email"
                                    value="{{ $purchase->guest->email ?? old('email', '') }}" />
                                @error('email')
                                    <div><small class="text-danger">{{ $message }}</small></div>
                                @enderror
                            </div>
                        @endif
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="play_id">Seleccionar obra</label>
                            <select class="p-1 rounded auth-form-input" name="play_id" id="play_id">
                                @foreach ($plays as $play)
                                    <option value="{{ $play->id }}"
                                        {{ $purchase->performance->play->id == $play->id ? 'selected' : '' }}>
                                        {{ $play->title }}</option>
                                @endforeach
                            </select>
                            @error('play_id')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="performance_id">Seleccionar función</label>
                            <select class="p-1 rounded auth-form-input" name="performance_id" id="performance_id">
                                @foreach ($performances as $performance)
                                    <option value="{{ $performance->id }}" data-play="{{ $performance->play_id }}"
                                        {{ $purchase->performance->id == $performance->id ? 'selected' : '' }}>
                                        {{ $performance->start_time->translatedFormat('l d/m/Y - H:i') }}</option>
                                @endforeach
                            </select>
                            @error('performance_id')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="ticket_amount">Cantidad de entradas</label>
                            <input class="p-1 rounded auth-form-input" type="number" name="ticket_amount"
                                id="ticket_amount" value="{{ old('ticket_amount', $purchase->ticket_amount) }}">
                            @error('ticket_amount')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column w-100 mb-2">
                            <label for="status">Estado de la transacción</label>
                            <select class="p-1 rounded auth-form-input" name="status" id="status">
                                <option value="approved"
                                    {{ old('status', $purchase->status) == 'confirmed' ? 'selected' : '' }}>Confirmada
                                </option>
                                <option value="pending"
                                    {{ old('status', $purchase->status) == 'pending' ? 'selected' : '' }}>Pendiente
                                </option>
                                <option value="rejected"
                                    {{ old('status', $purchase->status) == 'cancelled' ? 'selected' : '' }}>Cancelada
                                </option>
                            </select>
                            @error('status')
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

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const playSelect = document.getElementById('play_id');
        const performanceSelect = document.getElementById('performance_id');

        function filterPerformances() {

            const selectedPlay = playSelect.value;

            const currentPerformance = performanceSelect.value;

            Array.from(performanceSelect.options).forEach(option => {
                option.hidden = option.dataset.play !== selectedPlay;
            });

            const currentOption = Array.from(performanceSelect.options)
                .find(option => option.value === currentPerformance && !option.hidden);

            if (!currentOption) {
                const firstVisible = Array.from(performanceSelect.options)
                    .find(option => !option.hidden);

                if (firstVisible) {
                    performanceSelect.value = firstVisible.value;
                }
            }
        }

        playSelect.addEventListener('change', filterPerformances);

        filterPerformances();
    });
</script>
