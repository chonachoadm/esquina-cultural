@extends('layouts.app')

@section('content')
<section>
    <h2>Editar Compra (admin)</h2>
    <form action="{{ route('purchases.update', $purchase) }}" method="POST">
        @csrf
        @method('PUT')
        @if($purchase->user)
        <div>
            <label for="user_id">Seleccionar usuario</label>
            <select name="user_id" id="user_id">
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $purchase->user_id == $user->id ? 'selected' : '' }}>{{ $user->name ? $user->name : $user->email }}</option>
                @endforeach
            </select>
            @error('user_id')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        @elseif($purchase->guest)
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="name">Nombre</label>
                    <input 
                        class="p-1 rounded auth-form-input" 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ $purchase->guest->name ?? old('name', '') }}" />
                    @error('name')
                    <div><small class="text-danger">{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="email">Correo electrónico</label>
                    <input 
                        class="p-1 rounded auth-form-input" 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ $purchase->guest->email ?? old('email', '') }}" />
                    @error('email')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
        @endif
        <div>
            <label for="play_id">Seleccionar obra</label>
            <select name="play_id" id="play_id">
                @foreach($plays as $play)
                <option value="{{ $play->id }}" {{ $purchase->performance->play->id == $play->id ? 'selected' : '' }}>{{ $play->title }}</option>
                @endforeach
            </select>
            @error('play_id')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="performance_id">Seleccionar función</label>
            <select name="performance_id" id="performance_id" >
                @foreach($performances as $performance)
                <option value="{{ $performance->id }}" data-play="{{ $performance->play_id }}" {{ $purchase->performance->id == $performance->id ? 'selected' : '' }}>{{ $performance->start_time }}</option>
                @endforeach
            </select>
            @error('performance_id')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="ticket_amount">Cantidad de entradas</label>
            <input type="number" name="ticket_amount" id="ticket_amount" value="{{ old('ticket_amount', $purchase->ticket_amount) }}">
            @error('ticket_amount')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="payment_status">Estado de la transacción</label>
            <select name="payment_status" id="payment_status">
                <option value="approved" {{ old('payment_status', $purchase->payment_status) == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ old('payment_status', $purchase->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ old('payment_status', $purchase->payment_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('payment_status')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <button type="submit">Guardar</button>
        </div>
    </form>
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