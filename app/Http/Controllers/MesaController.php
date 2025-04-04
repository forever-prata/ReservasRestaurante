<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $hora_inicio = $request->input('hora_inicio');
        $hora_fim    = $request->input('hora_fim');

        $selectedDate = Carbon::parse($date);

        if ($selectedDate->isSunday()) {
            $availableMesas = collect();
        } else {
            $mesas = Mesa::all();

            if ($hora_inicio && $hora_fim) {
                if ($hora_inicio < '18:00' || $hora_fim > '23:59') {
                    $availableMesas = collect();
                } else {
                    $availableMesas = $mesas->filter(function ($mesa) use ($date, $hora_inicio, $hora_fim) {
                        $start = Carbon::parse($date . ' ' . $hora_inicio . ':00');
                        $end   = Carbon::parse($date . ' ' . $hora_fim . ':00');

                        $conflito = Reserva::where('mesa_id', $mesa->id)
                            ->whereDate('inicio', $date)
                            ->where(function ($query) use ($start, $end) {
                                $query->where(function ($q) use ($start, $end) {
                                    $q->where('inicio', '<', $end)
                                      ->where('fim', '>', $start);
                                });
                            })->exists();

                        return !$conflito;
                    });
                }
            } else {
                $availableMesas = $mesas;
            }
        }

        return view('mesas.index', compact('availableMesas', 'date', 'hora_inicio', 'hora_fim'));
    }
}
