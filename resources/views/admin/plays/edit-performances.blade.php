@extends('layouts.app')

@section('content')
<section>
    <h2>Modificar Funciones (Performances) {{ $play->title }}</h2>
    
    <div>
        <h3>Funciones Actuales</h3>
        @if($play->performances->count() > 0)
        <ul>
            @foreach($play->performances as $performance)
            <li>
                <p>{{ $performance->start_time }}</p>
                <form action="{{ route('performances.destroy', $performance) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Estás seguro de querer eliminar la función del {{ $performance->start_time }}?')">X</button>
                </form>
            </li>
            @endforeach
        </ul>
        @else
        <p>No hay funciones programadas.</p>
        @endif
    </div>

    <div>
        <h3>Agregar Nuevas Funciones</h3>
        <form action="{{ route('plays.update-performances', $play) }}" method="POST" id="add-performances-form">
            @csrf
            @method('PUT')
            
            <div>
                <label for="perf-date">Fecha</label>
                <input type="date" id="perf-date" />
            </div>
            
            <div>
                <label for="perf-time">Hora</label>
                <input type="time" id="perf-time" />
            </div>
            
            <button type="button" id="btn-add-performance">Agregar Función</button>
            
            <div id="new-performances-list" style="display:none;">
                <h4>Funciones a Agregar</h4>
                <ul id="performances-to-add">
                </ul>
            </div>

            <div>
                <button type="submit" id="btn-submit-performances" style="display:none;">Guardar Funciones</button>
            </div>
        </form>
    </div>
</section>

<script>
let newPerformances = [];

document.getElementById('btn-add-performance').addEventListener('click', function() {
    const date = document.getElementById('perf-date').value;
    const time = document.getElementById('perf-time').value;
    if (!date || !time) {
        alert('Por favor completa la fecha y la hora');
        return;
    }
    const startTime = `${date} ${time}:00`;
    const exists = newPerformances.some(p => p.start_time === startTime);
    if (exists) {
        alert('Esta función ya ha sido agregada');
        return;
    }
    newPerformances.push({ start_time: startTime });
    renderNewPerformances();
    document.getElementById('perf-date').value = '';
    document.getElementById('perf-time').value = '';
});

function removeNewPerformance(index) {
    newPerformances.splice(index, 1);
    renderNewPerformances();
}

function renderNewPerformances() {
    const list = document.getElementById('performances-to-add');
    list.innerHTML = '';
    newPerformances.forEach((perf, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            <span>${perf.start_time}</span>
            <button type="button" onclick="removeNewPerformance(${index})">X</button>
        `;
        list.append(li);
    });
    const listDiv = document.getElementById('new-performances-list');
    const submitBtn = document.getElementById('btn-submit-performances');
    if (newPerformances.length > 0) {
        listDiv.style.display = 'block';
        submitBtn.style.display = 'block';
    } else {
        listDiv.style.display = 'none';
        submitBtn.style.display = 'none';
    }
}

document.getElementById('add-performances-form').addEventListener('submit', function(event) {
    event.preventDefault();
    newPerformances.forEach((perf, index) => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = `new_performances[${index}]`;
        hiddenInput.value = perf.start_time;
        this.append(hiddenInput);
    });
    this.submit();
});
</script>

@endsection
