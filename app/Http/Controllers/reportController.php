<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class reportController extends Controller
{
    public function report()
    {   
        return view('reporte');
    }

    public function checkIn()
{
    $today = today()->toDateString();

    // Verifica si ya existe un registro para hoy
    $attendance = Attendance::firstOrCreate(
        [
            'user_id' => Auth::id(),
            'date' => $today,
        ],
        [
            'check_in' => now(),
            'status' => 'pendiente', // Puedes ajustar el valor según tu lógica
        ]
    );

    return back()->with('success', 'Entrada registrada');
}

public function checkOut()
{
    $attendance = Attendance::where('user_id', Auth::id())
        ->where('date', today()->toDateString())
        ->whereNull('check_out')
        ->latest()
        ->first();

    if ($attendance) {
        $attendance->update([
            'check_out' => now(),
            'status' => 'completo', // Marca como asistencia completa
        ]);
    }

    return back()->with('success', 'Salida registrada');
}

}
