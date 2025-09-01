<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\reportController;

use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, "index"])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/asistencia/entrada', [AttendanceController::class, 'checkIn'])
        ->name('attendance.checkIn');

    Route::post('/asistencia/salida', [AttendanceController::class, 'checkOut'])
        ->name('attendance.checkOut');

    Route::get('/dashboard/reporte', [reportController::class, 'report'])
        ->name('dashboard.report');
    Route::get('/dashboard/reporte', [reportController::class, 'report'])->name('dashboard.report');
    Route::get('/dashboard/reporte/pdf', [reportController::class, 'exportPdf'])->name('dashboard.report.pdf');


});




require __DIR__ . '/auth.php';
