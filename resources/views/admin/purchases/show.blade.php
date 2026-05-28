@extends('layouts.app')

@section('content')
<section>
    <h2>Compra nro. {{ $purchase->id }}</h2>
    <ul>
        <li>
            <p><strong>ID de la transacción:</strong> {{ $purchase->payment_gateway_id }}</p>
        </li>
        <li>
            <p><strong>Estado de la transacción:</strong> {{ $purchase->payment_status }}</p>
        </li>
        <li>
            <p><strong>Usuario:</strong> {{ $purchase->user->name }} ({{ $purchase->user->email }})</p>
        </li>
        <li>
            <p><strong>Cantidad de entradas adquiridas:</strong> {{ $purchase->ticket_amount }}</p>
        </li>
        <li>
            <p><strong>Total abonado:</strong> $ {{ $purchase->ticket_amount * $purchase->performance->play->ticket_price }}</p>
        </li>
        <li>
            <p><strong>Obra:</strong> {{ $purchase->performance->play->title }}</p>
        </li>
        <li>
            <p><strong>Función:</strong> {{ $purchase->performance->start_time }}</p>
        </li>
        <li>
            <p><strong>Fecha de la transacción:</strong> {{ $purchase->created_at }}</p>
        </li>
    </ul>
    
    <a href="{{ route('purchases.edit', $purchase) }}">Editar</a>

    <form action="{{ route('purchases.destroy', $purchase) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar esta compra?')">Eliminar</button>
    </form>
</section>

@endsection