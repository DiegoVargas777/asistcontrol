<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $marcas = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'asc') 
            ->orderBy('check_in', 'asc')
            ->get();

        return view('dashboard', compact('user', 'marcas'));
    }
}
