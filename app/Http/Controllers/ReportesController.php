<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
    /*ejemplo de controlador para reportes
    // Entradas atrasadas
public function atrasos() {
    return Asistencia::where('hora_entrada', '>', '09:30:00')->get();
}

// Salidas anticipadas
public function salidasAnticipadas() {
    return Asistencia::where('hora_salida', '<', '17:30:00')->get();
}

// Inasistencias
public function inasistencias(Request $request) {
    $fecha = $request->input('fecha', now()->toDateString());
    $usuariosConAsistencia = Asistencia::where('fecha', $fecha)->pluck('user_id');
    return User::whereNotIn('id', $usuariosConAsistencia)->get();
}
// Horas extras
public function horasExtras() {
    return Asistencia::whereRaw('TIMESTAMPDIFF(HOUR, hora_salida, "17:30:00") > 0')->get();
}
    

    */
}
