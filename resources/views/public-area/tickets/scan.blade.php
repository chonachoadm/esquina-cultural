@extends('layouts.app')
@section('content')
    <section class="section-personal py-4 flex-grow-1">
        <div class="billboard-detail-copy">
            <div id="ticket-scanner-result" class="mt-4"></div>

            <a class="billboard-detail-back-button" href="{{ route('profile') }}">
                <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
            </a>

            <div class="row justify-content-center my-4">
                <div class="col-12 col-md-6 text-center">
                    <h2 class="billboard-detail-comment-title mb-4">Escanear entrada</h2>

                    <div id="ticket-scanner" data-scan-url="{{ route('tickets.scan') }}"></div>

                </div>
            </div>
        </div>
    </section>
@endsection
