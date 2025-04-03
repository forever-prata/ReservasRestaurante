@extends('layouts.app')

@section('body')
<div class="container mt-5">
    <h2>Reserva para Mesa {{ $mesa->descricao }}</h2>
    <p>Data: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
    <form action="{{ route('reservas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="mesa_id" value="{{ $mesa->id }}">
        <input type="hidden" name="data" value="{{ $date }}">

        <div class="mb-3">
            <label class="form-label">Selecione o horário disponível:</label>
            @if(count($availableSlots) > 0)
                @foreach($availableSlots as $slot)
                <div class=\"form-check\">
                    <input class="form-check-input" type="radio" name="slot" id="slot_{{ $loop->index }}" value="{{ $slot['inicio'] }}-{{ $slot['fim'] }}">
                    <label class="form-check-label" for="slot_{{ $loop->index }}">
                        Das {{ $slot['inicio'] }} às {{ $slot['fim'] }}
                    </label>
                </div>
                @endforeach
            @else
                <p>Não há horários disponíveis para essa mesa neste dia.</p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Reservar</button>
    </form>
</div>
@endsection
