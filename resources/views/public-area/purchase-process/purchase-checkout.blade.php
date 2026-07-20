@extends('layouts.app')
@section('content')
<section class="section-public flex-grow-1">
    @if(session('message'))
    <div class="alert alert-warning">
        <small>{{ session('message') }}</small>
    </div>
    @elseif(session('success'))
    <div class="alert alert-success">
        <small>{{ session('success') }}</small>
    </div>
    @elseif(session('error'))
    <div class="alert alert-error">
        <small>{{ session('error') }}</small>
    </div>
    @endif

    <a class="billboard-detail-back-button" href="{{ route('compra.create', $purchase->performance->play->id) }}">
        <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
    </a>

    <div class="d-flex flex-column justify-content-center my-4 billboard-detail-copy">
        <div class="my-4 text-center">
            <h1 class="fw-bold">
                {{ $play->title }}
            </h1>    
            <div class="mt-2">
                <p class="m-0">{{ $play->theater->name }}</p>
                <small class="billboard-detail-theater-address">{{ $play->theater->short_address }}</small>
            </div>
        </div>
        <hr class="d-block d-lg-none my-2">
        <p class="text-center"><em>¡Ya casi es tuya!</em></p>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-start gap-4 p-2 my-4 rounded-3xl">
                <h2>Revisá tus datos antes de pagar</h2>
                <ul class="p-0">
                    @if($purchase->user)
                    <li><p><strong>Nombre: </strong>{{ $purchase->user->name }}</p></li>
                    <li><p><strong>Correo: </strong>{{ $purchase->user->email }}</p></li>
                    @elseif($purchase->guest)
                    <li><p><strong>Nombre: </strong>{{ $purchase->guest->name }}</p></li>
                    <li><p><strong>Correo: </strong>{{ $purchase->guest->email }}</p></li>
                    @endif
                    <li><p><strong>Fecha: </strong>{{ $purchase->performance->start_time->translatedFormat('l d/m/Y') }}</p></li>
                    <li><p><strong>Hora: </strong>{{ $purchase->performance->start_time->translatedFormat('H:i') }}</p></li>
                    <li><p><strong>Cantidad de entradas: </strong>{{ $purchase->ticket_amount }}</p></li>
                    <li><p><strong>Subtotal: </strong>$ {{ $subtotal }} ARS</p></li>
                    <li><p><strong>Costo de servicio: </strong>$ {{ $feeAmount }} ARS</p></li>
                    <li><p><strong>Monto total: </strong>$ {{ $purchase->total_amount }} ARS</p></li>
                </ul>
            </div>
        </div>
        <a href="{{ route('payment.checkout', $purchase) }}">Pagar con Mercado Pago</a>
    </div>
</section>
@endsection