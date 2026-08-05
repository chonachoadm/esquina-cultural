@extends('layouts.app')

@section('content')
    <section class="section-personal py-4">
        @if (session('message'))
            <div class="mt-4 alert alert-warning">
                <small class="mx-4">{{ session('message') }}</small>
            </div>
        @elseif(session('success'))
            <div class="mt-4 alert alert-success">
                <small class="mx-4">{{ session('success') }}</small>
            </div>
        @elseif(session('error'))
            <div class="mt-4 alert alert-danger">
                <small class="mx-4">{{ session('error') }}</small>
            </div>
        @endif

        <div class="m-4">
            <a class="billboard-detail-back-button" href="{{ route('purchases.index') }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>
        </div>

        <div>
            <div class="d-flex justify-content-center align-items-center gap-4">
                <h1 class="billboard-detail-comment-title">Compra Nro. {{ $purchase->id }}</h1>
                <div class="m-4 d-flex gap-2">
                    <a class="btn btn-primary" href="{{ route('purchases.edit', $purchase) }}">Editar</a>

                    <form action="{{ route('purchases.destroy', $purchase) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit"
                            onclick="return confirm('¿Estás seguro de querer eliminar esta compra?')">Eliminar</button>
                    </form>
                </div>
            </div>
            <div class="rounded-3xl p-4 mb-4 billboard-detail-copy auth-form-input">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Estado de la compra</td>
                            <td>{{ $purchase->status }}</td>
                        </tr>
                        <tr>
                            @if ($purchase->user)
                                <td>Usuario</td>
                                <td>{{ $purchase->user->name }} ({{ $purchase->user->email }})</td>
                            @else
                                <td>Usuario</td>
                                <td>{{ $purchase->guest->name }} ({{ $purchase->guest->email }})</td>
                            @endif
                        </tr>
                        <tr>
                            <td>Precio de la entrada</td>
                            <td>$ {{ $purchase->performance->play->ticket_price }}</td>
                        </tr>
                        <tr>
                            <td>Cantidad de entradas adquiridas</td>
                            <td>{{ $purchase->ticket_amount }}</td>
                        </tr>
                        <tr>
                            <td>Porcentaje de comisión</td>
                            <td>{{ $purchase->platform_fee_rate }}%</td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td>$ {{ $purchase->subtotal }}</td>
                        </tr>
                        <tr>
                            <td>Total abonado</td>
                            <td>$ {{ $purchase->total_amount }}</td>
                        </tr>
                        <tr>
                            <td>Obra</td>
                            <td>{{ $purchase->performance->play->title }}</td>
                        </tr>
                        <tr>
                            <td>Función</td>
                            <td>{{ $purchase->performance->start_time->translatedFormat('l d/m/Y - H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Fecha de la transacción</td>
                            <td>{{ $purchase->created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </section>
@endsection