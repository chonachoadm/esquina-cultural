<div class="row justify-content-center my-4">
    <div class="col-12 col-md-6 text-center">
        <h2 class="billboard-detail-comment-title">{{ $ticket->performance->play->title }}</h2>
        <div class="mb-4">
            <p class="m-0"><strong>{{ $ticket->performance->play->theater->name }}</strong></p>
            <small>{{ $ticket->performance->play->theater->short_address }}</small>
        </div>
        <p class="mb-1">{{ $ticket->performance->start_time->locale('es')->isoFormat('dddd D [de] MMMM, H:mm') }}</p>
        <p class="mb-2"><em>{{ $ticket->purchase->ticket_amount }}
                {{ $ticket->purchase->ticket_amount == 1 ? 'entrada' : 'entradas' }}</em></p>

        <div>
            <img src="{{ upload_asset('tickets/qr_' . $ticket->id . '.png') }}" alt="Código QR">
        </div>

        <p class="text-center"><small>{{ $ticket->ticket_code }}</small></p>
    </div>
</div>
