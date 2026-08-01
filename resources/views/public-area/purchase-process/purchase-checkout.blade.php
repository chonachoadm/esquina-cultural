@extends('layouts.app')
@section('content')
    <section class="section-public py-4 flex-grow-1">
        @if (session('message'))
            <div class="alert alert-warning m-4">
                <small>{{ session('message') }}</small>
            </div>
        @elseif(session('success'))
            <div class="alert alert-success m-4">
                <small>{{ session('success') }}</small>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger m-4">
                <small>{{ session('error') }}</small>
            </div>
        @endif

        <a class="billboard-detail-back-button" href="{{ route('compra.create', $purchase->performance->play->id) }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
        </a>

        <div class="d-flex flex-column justify-content-center my-4 billboard-detail-copy">
            <div class="row justify-content-center">
                <div
                    class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-start gap-4 p-4 my-4 rounded-3xl auth-forms">
                    <h1>Revisá tus datos antes de pagar</h1>
                    <ul class="p-0">
                        @if ($purchase->user)
                            <li>
                                <p><strong>Nombre: </strong>{{ $purchase->user->name }}</p>
                            </li>
                            <li>
                                <p><strong>Correo: </strong>{{ $purchase->user->email }}</p>
                            </li>
                        @elseif($purchase->guest)
                            <li>
                                <p><strong>Nombre: </strong>{{ $purchase->guest->name }}</p>
                            </li>
                            <li>
                                <p><strong>Correo: </strong>{{ $purchase->guest->email }}</p>
                            </li>
                        @endif
                        <li>
                            <p><strong>Obra: </strong>{{ $play->title }}</p>
                        </li>
                        <li>
                            <p><strong>Teatro: </strong>{{ $play->theater->name }}</p>
                        </li>
                        <li>
                            <p><strong>Dirección: </strong>{{ $play->theater->short_address }}</p>
                        </li>
                        <li>
                            <p><strong>Fecha y hora:
                                </strong>{{ $purchase->performance->start_time->translatedFormat('l d/m/Y') }} -
                                {{ $purchase->performance->start_time->translatedFormat('H:i') }}</p>
                        </li>
                        <li>
                            <p><strong>Cantidad de entradas: </strong>{{ $purchase->ticket_amount }}</p>
                        </li>
                        <li>
                            <p><strong>Subtotal: </strong>$ {{ $subtotal }} ARS</p>
                        </li>
                        <li>
                            <p><strong>Costo de servicio: </strong>$ {{ $feeAmount }} ARS</p>
                        </li>
                        <li>
                            <p><strong>Monto total: </strong>$ {{ $purchase->total_amount }} ARS</p>
                        </li>
                    </ul>
                    <a class="rounded px-4 py-2 mx-auto mercadopago-button"
                        href="{{ route('payment.checkout', $purchase) }}"><img class="img img-fluid mx-auto"
                            src="{{ asset('storage/images/icons/icon-mercadopago.svg') }}"
                            alt="Pagar con Mercado Pago"></a>
                    <p class="w-100 m-0 text-center"><em>¡Ya casi es tuya!</em></p>
                </div>
            </div>
        </div>
    </section>
@endsection
