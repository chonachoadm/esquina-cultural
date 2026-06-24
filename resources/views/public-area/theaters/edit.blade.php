@extends('layouts.app')

@section('content')
<section class="section-personal flex-grow-1">
    <div class="my-4">
        <a class="billboard-detail-back-button" href="{{ route('teatros.index') }}">
            <img class="img-fluid" src="{{ asset('storage/images/icons/back-black-25.webp') }}" alt="Volver">
        </a>

        <div class="row justify-content-center billboard-detail-copy">
            <form class="col-12 col-md-6 col-lg-4d-flex flex-column align-items-center gap-4 p-4 my-4 rounded-3xl auth-forms" action="{{ route('teatros.store', auth()->user()) }}" method="POST">
                @csrf
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="name">Nombre</label>
                    <input class="p-1 rounded auth-form-input" type="text" name="name" id="name" value="{{ old('name', $theater->name) }}" />
                    @error('name')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="bio">Biografía</label>
                    <textarea class="p-1 rounded auth-form-input" type="text" name="bio" id="bio">{{ old('bio', $theater->bio) }}</textarea>
                    @error('bio')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="address">Ubicación</label>
                    <input class="p-1 rounded auth-form-input" type="text" id="address" name="address" autocomplete="off" value="{{ old('address', $theater->address) }}">

                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $theater->latitude) }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $theater->longitude) }}">

                    <div id="suggestions"></div>
                    <div id="map"></div>
                    @error('address')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="d-flex flex-column w-100 mb-2">
                    <label for="capacity">Máxima capacidad de la sala</label>
                    <input class="p-1 rounded auth-form-input" type="number" id="capacity" name="capacity" value="{{ old('capacity', $theater->max_capacity) }}">
                    @error('capacity')
                    <div><small>{{ $message }}</small></div>
                    @enderror
                </div>
                    <button class="w-100 landing-auth-button" type="submit">Enviar a revisión</button>
            </form>
        </div>
    </div>

</section>
@endsection

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const input = document.getElementById('address');
    const suggestions = document.getElementById('suggestions');

    const theaterLat = {{ $theater->latitude ?? -34.6037 }};
    const theaterLon = {{ $theater->longitude ?? -58.3816 }};

    const map = L.map('map').setView([theaterLat, theaterLon], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker;

    if (theaterLat && theaterLon) {
        marker = L.marker([theaterLat, theaterLon]).addTo(map);
    }

    async function searchPlaces(query) {
        if (query.length < 3) {
            suggestions.innerHTML = '';
            return;
        }
        const url =
            `https://nominatim.openstreetmap.org/search?` +
            `format=json&` +
            `q=${encodeURIComponent(query)}&` +
            `countrycodes=ar&` +
            `bounded=1&` +
            `viewbox=-58.5313,-34.5263,-58.3351,-34.7056`;
        const response = await fetch(url);
        const data = await response.json();
        suggestions.innerHTML = '';
        data.forEach(place => {
            const item = document.createElement('div');
            item.textContent = place.display_name;
            item.addEventListener('click', () => {

                input.value = place.display_name;

                document.getElementById('latitude').value = place.lat;
                document.getElementById('longitude').value = place.lon;

                suggestions.innerHTML = '';

                const lat = parseFloat(place.lat);
                const lon = parseFloat(place.lon);

                map.setView([lat, lon], 16);

                if (marker) {
                    marker.remove();
                }

                marker = L.marker([lat, lon]).addTo(map);
            });

            suggestions.appendChild(item);
        });
    }
    let timeout;
    input.addEventListener('input', () => {
    
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
    
        clearTimeout(timeout);
    
        timeout = setTimeout(() => {
            searchPlaces(input.value);
        }, 300);
    });
});
</script>