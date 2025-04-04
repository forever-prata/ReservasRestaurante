@extends('layouts.app')

@section('body')
<div class="container mt-5">
    <h2 class="text-center mb-4">Mesas Disponíveis</h2>

    <div class="d-flex justify-content-center mb-4">
        <form id="filterForm" action="{{ route('mesas.index') }}" method="GET" class="col-md-8 col-lg-6">
            <div class="row g-2">
                <div class="col-4">
                    <input type="date" name="date" id="reservaData" class="form-control text-center"
                           value="{{ $date }}" min="{{ now()->format('Y-m-d') }}">
                </div>
                <div class="col-4">
                    <select name="hora_inicio" id="horaInicio" class="form-control text-center">
                        <option value="">Início</option>
                        @for($h = 18; $h <= 23; $h++)
                            @php $time = sprintf('%02d:00', $h); @endphp
                            <option value="{{ $time }}" {{ (isset($hora_inicio) && $hora_inicio == $time) ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-4">
                    <select name="hora_fim" id="horaFim" class="form-control text-center">
                        <option value="">Término</option>
                        @for($h = 19; $h <= 23; $h++)
                            @php $time = sprintf('%02d:00', $h); @endphp
                            <option value="{{ $time }}" {{ (isset($hora_fim) && $hora_fim == $time) ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endfor
                        <option value="23:59" {{ (isset($hora_fim) && $hora_fim == '23:59') ? 'selected' : '' }}>23:59</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if(\Carbon\Carbon::parse($date)->isSunday())
        <div class="alert alert-danger text-center">
            Reservas não são permitidas aos domingos.
        </div>
    @endif

    <div class="row justify-content-center" id="mesasContainer">
        @forelse($availableMesas as $mesa)
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $mesa->descricao }}</h5>
                        @if(isset($hora_inicio) && !empty($hora_inicio) && isset($hora_fim) && !empty($hora_fim))
                            <form action="{{ route('reservas.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="mesa_id" value="{{ $mesa->id }}">
                                <input type="hidden" name="data" value="{{ $date }}">
                                <input type="hidden" name="hora_inicio" value="{{ $hora_inicio }}">
                                <input type="hidden" name="hora_fim" value="{{ $hora_fim }}">
                                <button type="submit" class="btn btn-primary">Reservar</button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>Preencha data e horário</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">Nenhuma mesa disponível para o período selecionado.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterForm = document.getElementById('filterForm');
        const dateInput = document.getElementById('reservaData');
        const horaInicio = document.getElementById('horaInicio');
        const horaFim = document.getElementById('horaFim');

        function isDomingo(dateString) {
            if (!dateString) return false;
            const parts = dateString.split('-');
            const date = new Date(parts[0], parts[1] - 1, parts[2]);
            return date.getDay() === 0;
        }

        function validateTime() {
            const startTime = horaInicio.value;
            const endTime = horaFim.value;
            let valid = true;
            if (startTime && endTime && startTime >= endTime) {
                alert('O horário de término precisa ser maior que o horário de início. Ajustando automaticamente para +1 hora.');
                let [h, m] = startTime.split(':');
                let newHour = parseInt(h, 10) + 1;
                newHour = newHour < 10 ? '0' + newHour : newHour;
                let newTime = newHour + ':' + m;
                if (newTime > '23:59') {
                    newTime = '23:59';
                }
                horaFim.value = newTime;
                valid = false;
            }
            return valid;
        }

        function submitFilterForm() {
            if (!validateTime()) {
                setTimeout(() => { filterForm.submit(); }, 500);
            } else {
                filterForm.submit();
            }
        }

        dateInput.addEventListener('change', function() {
            if (isDomingo(this.value)) {
                alert('Domingos não estão disponíveis para reserva. Por favor, selecione outro dia.');
                this.value = '';
                return;
            }
            submitFilterForm();
        });

        horaInicio.addEventListener('change', submitFilterForm);
        horaFim.addEventListener('change', submitFilterForm);
    });
</script>
@endsection
