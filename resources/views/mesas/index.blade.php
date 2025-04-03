@extends('layouts.app')

@section('body')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Mesas Disponíveis</h2>

        <div class="d-flex justify-content-center">
            <div class="mb-4 col-md-4 col-lg-3">
                <input type="date" id="reservaData" class="form-control text-center" min="{{ now()->format('Y-m-d') }}">
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach($mesas as $mesa)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">{{ $mesa->descricao }}</h5>
                            <a href="#" class="btn btn-primary reservar-btn" data-mesa="{{ $mesa->id }}">
                                Reservar
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll('.reservar-btn');
            const dateInput = document.getElementById('reservaData');

            function isDomingo(dateString) {
                if (!dateString) return false;

                const parts = dateString.split('-');
                const date = new Date(parts[0], parts[1] - 1, parts[2]);

                return date.getDay() === 0;
            }

            dateInput.addEventListener('change', function() {
                if (isDomingo(this.value)) {
                    alert('Domingos não estão disponíveis para reserva. Por favor, selecione outro dia.');
                    this.value = '';
                    return false;
                }
            });

            buttons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const mesaId = this.getAttribute('data-mesa');
                    const selectedDate = dateInput.value;

                    if (!selectedDate) {
                        alert('Por favor, selecione um dia antes de reservar.');
                        return;
                    }

                    if (isDomingo(selectedDate)) {
                        alert('Domingos não estão disponíveis para reserva. Por favor, selecione outro dia.');
                        return;
                    }

                    const reservaUrl = "{{ route('reservas.create') }}" + "?mesa_id=" + mesaId + "&date=" + selectedDate;
                    window.location.href = reservaUrl;
                });
            });
        });
    </script>
@endsection
