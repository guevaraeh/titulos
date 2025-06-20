<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TitulationCertificateController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    //return Inertia::render('welcome');
    //return redirect(route('login'));
    //return redirect(route('titulation_certificate.create_fast'));
    return view('dashboard');
})->name('home');

Route::get('/generate-pdf-empty', [TitulationCertificateController::class, 'generate_pdf_empty'])->name('titulation_certificate.generate_pdf_empty');
Route::get('/search-certificates', [TitulationCertificateController::class, 'search_certificates'])->name('titulation_certificate.search_certificates');
Route::post('/get-certificates-ajax', [TitulationCertificateController::class, 'get_certificates_ajax'])->name('titulation_certificate.get_certificates_ajax');
Route::get('/certificate/{data}', [TitulationCertificateController::class, 'certificate'])->name('titulation_certificate.certificate');
Route::post('/student/get-students-by-career-ajax', [StudentController::class, 'get_students_by_career_ajax'])->name('student.get_students_by_career_ajax');

Route::get('/create-fast-certificate', [TitulationCertificateController::class, 'create_fast'])->name('titulation_certificate.create_fast');
Route::post('/generate-fast-certificate', [TitulationCertificateController::class, 'generate_pdf_fast'])->name('titulation_certificate.generate_pdf_fast');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        //return Inertia::render('dashboard');
        return Inertia::location(route('titulation_certificate'));
    })->name('dashboard');

    Route::get('/titulation_certificate', [TitulationCertificateController::class, 'index'])->name('titulation_certificate');
    Route::get('/titulation_certificate/create', [TitulationCertificateController::class, 'create'])->name('titulation_certificate.create');
    Route::post('/titulation_certificate', [TitulationCertificateController::class, 'store'])->name('titulation_certificate.store');
    Route::get('/titulation_certificate/{titulation_certificate}', [TitulationCertificateController::class, 'show'])->name('titulation_certificate.show');
    Route::get('/titulation_certificate/{titulation_certificate}/edit', [TitulationCertificateController::class, 'edit'])->name('titulation_certificate.edit');
    Route::put('/titulation_certificate/{titulation_certificate}', [TitulationCertificateController::class, 'update'])->name('titulation_certificate.update');
    Route::post('/titulation_certificate/{titulation_certificate}/add', [TitulationCertificateController::class, 'add_student'])->name('titulation_certificate.add_student');
    //Route::get('/titulation_certificate/{titulation_certificate}/drop/{student}', [TitulationCertificateController::class, 'drop_student'])->name('titulation_certificate.drop_student');
    Route::delete('/titulation_certificate/{titulation_certificate}/drop/{student}', [TitulationCertificateController::class, 'drop_student'])->name('titulation_certificate.drop_student');
    Route::get('/titulation_certificate/{titulation_certificate}/generate-pdf', [TitulationCertificateController::class, 'generate_pdf'])->name('titulation_certificate.generate_pdf');
    //Route::get('/generate-pdf-empty', [TitulationCertificateController::class, 'generate_pdf_empty'])->name('titulation_certificate.generate_pdf_empty');
    
    //Route::get('/search-certificates', [TitulationCertificateController::class, 'search_certificates'])->name('titulation_certificate.search_certificates');
    //Route::post('/get-certificates-ajax', [TitulationCertificateController::class, 'get_certificates_ajax'])->name('titulation_certificate.get_certificates_ajax');

    //Route::get('/create-fast-certificate', [TitulationCertificateController::class, 'create_fast'])->name('titulation_certificate.create_fast');
    //Route::post('/generate-fast-certificate', [TitulationCertificateController::class, 'generate_pdf_fast'])->name('titulation_certificate.generate_pdf_fast');

    Route::delete('/titulation_certificate/{titulation_certificate}/destroy', [TitulationCertificateController::class, 'destroy'])->name('titulation_certificate.destroy');

    Route::get('/student', [StudentController::class, 'index'])->name('student');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{student}', [StudentController::class, 'show'])->name('student.show');
    Route::get('/student/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/{student}', [StudentController::class, 'update'])->name('student.update');
    Route::post('/student/get-students-ajax', [StudentController::class, 'get_students_ajax'])->name('student.get_students_ajax');
    //Route::post('/student/get-students-by-career-ajax', [StudentController::class, 'get_students_by_career_ajax'])->name('student.get_students_by_career_ajax');
    Route::delete('/student/{student}/destroy', [StudentController::class, 'destroy'])->name('student.destroy');

    Route::get('/students-import', function () {
        return view('student.import');
    })->name('import');
    Route::post('/students-import', [StudentController::class, 'import'])->name('student.import');

    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}/update', [UserController::class, 'update'])->name('user.update');
    Route::put('/user/{user}/update-password', [UserController::class, 'update_password'])->name('user.update_password');

    Route::get('/download-example', function () {
        $ruta = public_path("ejemplo.xlsx");
        if (file_exists($ruta)) {
            return response()->download($ruta);
            } else {
            abort(404, 'Archivo no encontrado.');
        }
    })->name('download_example');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
