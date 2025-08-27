<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{


    public function checkIn()
    {

        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', today()->toDateString());

        Attendance::create([
            'user_id' => Auth::id(),
            'check_in' => now(),
            'date' => now(),
        ]);

        return back()->with('success', 'Entrada registrada');
    }

    public function checkOut()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            //    ->where('date', today()->get())
            ->whereNull('check_out')
            ->latest()
            ->first();


        if ($attendance) {
            $attendance->update(['check_out' => now()]);
        }

        return back()->with('success', 'Salida registrada');
    }
}
