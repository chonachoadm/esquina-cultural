@extends('layouts.app')

@section('content')
    <section class="section-personal py-4">
        <div class="m-4">
            <h1 class="mb-4">Compras</h1>
            <a class="rounded px-4 py-2 btn btn-success" href="{{ route('purchases.create') }}">Crear compra</a>
        </div>

        <div class="rounded-3xl p-4 mb-4 table-responsive billboard-detail-copy auth-form-input">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Obra</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Monto abonado</th>
                        <th scope="col">Estado del pago</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td scope="row">{{ $purchase->id }}</td>
                            @if ($purchase->user)
                                <td>{{ $purchase->user->name }}</td>
                            @elseif($purchase->guest)
                                <td>{{ $purchase->guest->name }} <em>(Invitado)</em></td>
                            @endif
                            <td>{{ $purchase->performance?->play?->title ?? 'Obra eliminada'}}</td>
                            <td>{{ $purchase->performance?->start_time}}</td>
                            <td>$ {{ $purchase->performance?->play?->ticket_price * $purchase->ticket_amount}} ARS</td>
                            <td>{{ $purchase->status }}</td>
                            <td>
                                <a class="rounded px-2 py-1 billboard-ticket-button"
                                    href="{{ route('purchases.show', $purchase) }}">Ver</a>
                                <a class="rounded px-2 py-1 btn btn-primary"
                                    href="{{ route('purchases.edit', $purchase) }}">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
