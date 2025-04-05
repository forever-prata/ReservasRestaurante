<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Mesa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with('mesa', 'user')->get();
        return view('reservas.index', compact('reservas'));
    }

    public function create(Request $request)
    {
        $mesa_id = $request->input('mesa_id');
        $date = $request->input('date', now()->format('Y-m-d'));

        $selectedDate = Carbon::parse($date);
        if ($selectedDate->isSunday()) {
            return redirect()->back()->withErrors('Reservas não são permitidas aos domingos.');
        }

        $start = Carbon::parse($date . ' 18:00:00');
        $end = Carbon::parse($date . ' 23:59:59');

        $slots = [];
        $current = $start->copy();
        while ($current->lt($end)) {
            $slotEnd = $current->copy()->addHour();
            if ($slotEnd->gt($end)) {
                $slotEnd = $end->copy();
            }
            $slots[] = [
                'inicio'    => $current->format('H:i'),
                'fim'       => $slotEnd->format('H:i'),
                'start_obj' => $current->copy(),
                'end_obj'   => $slotEnd->copy(),
            ];
            $current->addHour();
        }

        $reservas = Reserva::where('mesa_id', $mesa_id)
            ->whereDate('inicio', $date)
            ->get();

        $availableSlots = [];
        foreach ($slots as $slot) {
            $overlap = false;
            foreach ($reservas as $reserva) {
                $reservaStart = Carbon::parse($reserva->inicio);
                $reservaEnd   = Carbon::parse($reserva->fim);
                if ($slot['start_obj']->lt($reservaEnd) && $slot['end_obj']->gt($reservaStart)) {
                    $overlap = true;
                    break;
                }
            }
            if (!$overlap) {
                $availableSlots[] = $slot;
            }
        }

        $mesa = Mesa::findOrFail($mesa_id);
        return view('reservas.create', compact('mesa', 'availableSlots', 'date'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'data'    => 'required|date',
            'hora_inicio' => 'required',
            'hora_fim'    => 'required',
        ]);

        $date = $validated['data'];
        $inicio = Carbon::parse($date . ' ' . $validated['hora_inicio'] . ':00');
        $fim    = Carbon::parse($date . ' ' . $validated['hora_fim'] . ':00');

        if ($inicio->format('H:i') < '18:00' || $fim->format('H:i') > '23:59') {
            return back()->withErrors(['Horários de reserva devem estar entre 18:00 e 23:59.'])->withInput();
        }

        $conflito = Reserva::where('mesa_id', $validated['mesa_id'])
        ->whereDate('inicio', $date)
        ->where(function ($query) use ($inicio, $fim) {
            $query->where(function ($q) use ($inicio, $fim) {
                $q->where('inicio', '<', $fim)
                  ->where('fim', '>', $inicio);
            });
        })->exists();

        if ($conflito) {
            return back()->withErrors(['A mesa já está reservada para esse período.'])->withInput();
        }

        Reserva::create([
            'user_id' => auth()->id(),
            'mesa_id' => $validated['mesa_id'],
            'inicio'  => $inicio,
            'fim'     => $fim,
        ]);

        return redirect()->route('mesas.index')->with('success', 'Reserva realizada com sucesso!');
    }
}

