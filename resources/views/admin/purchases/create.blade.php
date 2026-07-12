@extends('layouts.app')

@section('content')
<section>
    <h2>Crear Compra (admin)</h2>
    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <div>
            <label for="user_id">Seleccionar usuario</label>
            <select name="user_id" id="user_id">
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name ? $user->name : $user->email }}</option>
                @endforeach
            </select>
            @error('user_id')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="play_id">Seleccionar obra</label>
            <select name="play_id" id="play_id">
                @foreach($plays as $play)
                <option value="{{ $play->id }}">{{ $play->title }}</option>
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
                <option value="{{ $performance->id }}" data-play="{{ $performance->play_id }}">{{ $performance->start_time }}</option>
                @endforeach
            </select>
            @error('performance_id')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="ticket_amount">Cantidad de entradas</label>
            <input type="number" name="ticket_amount" id="ticket_amount">
            @error('ticket_amount')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <label for="payment_status">Estado de la transacción</label>
            <select name="payment_status" id="payment_status">
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>
            @error('payment_status')
            <div><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div>
            <button type="submit">Crear</button>
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
        
        Array.from(performanceSelect.options).forEach(option => {
            option.hidden = option.dataset.play !== selectedPlay;
        });
        
        const firstVisible = Array.from(performanceSelect.options)
        .find(option => !option.hidden);
        
        if (firstVisible) {
            performanceSelect.value = firstVisible.value;
        }
    }
    
    playSelect.addEventListener('change', filterPerformances);

    filterPerformances();
})
</script>