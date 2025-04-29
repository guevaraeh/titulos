<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TitulationCertificateController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    //return Inertia::render('welcome');
    return redirect(route('login'));
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        //return Inertia::render('dashboard');
        return Inertia::location(route('titulation_certificate'));
    })->name('dashboard');

    Route::get('/titulation_certificate', [TitulationCertificateController::class, 'index'])->name('titulation_certificate');
    Route::get('/titulation_certificate/create', [TitulationCertificateController::class, 'create'])->name('titulation_certificate.create');

    Route::get('/student', [StudentController::class, 'index'])->name('student');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
