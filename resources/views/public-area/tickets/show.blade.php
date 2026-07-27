@extends('layouts.app')
@section('content')

<section class="section-personal flex-grow-1">
    <div class="billboard-detail-copy">
        
        <a class="billboard-detail-back-button" href="{{ route('profile') }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
        </a>

        <div class="row justify-content-center my-4">
            <div class="col-12 col-md-6 text-center">
                <h2 class="billboard-detail-comment-title">{{ $ticket->performance->play->title }}</h2>
                <p class="mb-1">{{ $ticket->performance->start_time->locale('es')->isoFormat('dddd D [de] MMMM, H:mm') }}</p>
                <p class="mb-4"><em>{{ $ticket->purchase->ticket_amount }} {{ $ticket->purchase->ticket_amount == 1 ? 'entrada' : 'entradas' }}</em></p>

                <div class="d-flex justify-content-center my-4">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($ticket->ticket_code) !!}
                </div>

                <p class="text-center"><small>{{ $ticket->ticket_code }}</small></p>
            </div>
        </div>
    </div>
</section>

@endsection
