@extends('layouts.app')

@section('content')
<section>
    <h2>Todas las compras (admin)</h2>
    <a href="{{ route('purchases.create') }}">Crear compra</a>


    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Obra</th>
                <th>Fecha</th>
                <th>Monto abonado</th>
                <th>Estado del pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->id }}</td>
                @if($purchase->user)
                <td>{{ $purchase->user->name }}</td>
                @elseif($purchase->guest)
                <td>{{ $purchase->guest->name }} <em>(Invitado)</em></td>
                @endif
                <td>{{ $purchase->performance->play->title }}</td>
                <td>{{ $purchase->performance->start_time }}</td>
                <td>$ {{ $purchase->performance->play->ticket_price * $purchase->ticket_amount }} ARS</td>
                <td>{{ $purchase->payment_status }}</td>
                <td>
                    <a href="{{ route('purchases.show', $purchase) }}">Ver</a>
                    <a href="{{ route('purchases.edit', $purchase) }}">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

@endsection