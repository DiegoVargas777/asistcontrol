<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User; // <-- ESTA LÍNEA
use App\Models\Attendance; // <-- si también usas Attendance

class reportController extends Controller
{
    public function report(Request $request)
    {
        $query       = $request->input('query');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin    = $request->input('fechaFin');

        // Lista de usuarios para el desplegable
        $users = User::orderBy('name', 'asc')->get(['id', 'name']);

        $attendances = Attendance::with('user')
            ->when($query, function ($q) use ($query) {
                $q->where('user_id', $query);
            })
            ->when($fechaInicio && $fechaFin, function ($q) use ($fechaInicio, $fechaFin) {
                $q->whereBetween('date', [$fechaInicio, $fechaFin]);
            })
            ->orderBy('date', 'desc')
            ->get();

        return view('reporte', compact('attendances', 'users'));
    }
}