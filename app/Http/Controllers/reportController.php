<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Attendance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class reportController extends Controller
{
    public function report(Request $request)
    {
        $query       = $request->input('query');       // ID usuario
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin    = $request->input('fechaFin');
        $tipo        = $request->input('tipo');        // general, atrasos, salidas, inasistencias

        $users = User::orderBy('name', 'asc')->get(['id', 'name']);

        $attendances = Attendance::with('user')
            ->when($query, fn($q) => $q->where('user_id', $query))
            ->when($fechaInicio && $fechaFin, fn($q) => $q->whereBetween('date', [$fechaInicio, $fechaFin]))
            ->when($tipo === 'atrasos', fn($q) => $q->where('check_in', '>', '09:30:00'))
            ->when($tipo === 'salidas', fn($q) => $q->where('check_out', '<', '17:30:00'))
            ->orderBy('date', 'desc')
            ->get();

        // Inasistencias: días sin registros
        $inasistencias = collect();
        if ($tipo === 'inasistencias' && $fechaInicio && $fechaFin && $query) {
            $rangoFechas = collect();
            $fecha = Carbon::parse($fechaInicio);
            $fin   = Carbon::parse($fechaFin);

            while ($fecha->lte($fin)) {
                $rangoFechas->push($fecha->format('Y-m-d'));
                $fecha->addDay();
            }

            $fechasConAsistencia = $attendances->pluck('date')->unique();
            $fechasSinAsistencia = $rangoFechas->diff($fechasConAsistencia);

            foreach ($fechasSinAsistencia as $dia) {
                $inasistencias->push([
                    'user_id' => $query,
                    'name'    => optional(User::find($query))->name,
                    'date'    => $dia
                ]);
            }
        }

        return view('reporte', compact('attendances', 'users', 'tipo', 'inasistencias'));
    }

    public function exportPdf(Request $request)
    {
        $query       = $request->input('query');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin    = $request->input('fechaFin');
        $tipo        = $request->input('tipo');

        $attendances = Attendance::with('user')
            ->when($query, fn($q) => $q->where('user_id', $query))
            ->when($fechaInicio && $fechaFin, fn($q) => $q->whereBetween('date', [$fechaInicio, $fechaFin]))
            ->when($tipo === 'atrasos', fn($q) => $q->where('check_in', '>', '09:30:00'))
            ->when($tipo === 'salidas', fn($q) => $q->where('check_out', '<', '17:30:00'))
            ->orderBy('date', 'desc')
            ->get();

        $inasistencias = collect();
        if ($tipo === 'inasistencias' && $fechaInicio && $fechaFin && $query) {
            $rangoFechas = collect();
            $fecha = Carbon::parse($fechaInicio);
            $fin   = Carbon::parse($fechaFin);

            while ($fecha->lte($fin)) {
                $rangoFechas->push($fecha->format('Y-m-d'));
                $fecha->addDay();
            }

            $fechasConAsistencia = $attendances->pluck('date')->unique();
            $fechasSinAsistencia = $rangoFechas->diff($fechasConAsistencia);

            foreach ($fechasSinAsistencia as $dia) {
                $inasistencias->push([
                    'user_id' => $query,
                    'name'    => optional(User::find($query))->name,
                    'date'    => $dia
                ]);
            }
        }

        // Usar siempre la misma vista PDF y pasar todas las variables
        $pdf = Pdf::loadView('report-pdf', [
            'attendances'   => $attendances,
            'inasistencias' => $inasistencias,
            'fechaInicio'   => $fechaInicio,
            'fechaFin'      => $fechaFin,
            'tipo'          => $tipo
        ]);

        return $pdf->download('reporte_asistencia.pdf');
    }
}