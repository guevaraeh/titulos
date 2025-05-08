<?php

namespace App\Http\Controllers;

use App\Models\TitulationCertificate;
use App\Models\Student;
use App\Models\Career;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class TitulationCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['url_from' => route('titulation_certificate')]);
        return view('titulation_certificate.index',['titulation_certificates' => TitulationCertificate::orderBy('id', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('titulation_certificate.create',['students' => Student::orderBy('lastname','ASC')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->collect());
        $titulation_certificate = new TitulationCertificate;
        $titulation_certificate->type = $request->input('type');
        $titulation_certificate->project_name = $request->input('type') == '0' ? $request->input('project-name') : null;
        $titulation_certificate->certificate_date = $request->input('certificate-date') ? date('Y-m-d', strtotime($request->input('certificate-date'))) : null;
        $titulation_certificate->remarks = $request->input('remarks');
        $titulation_certificate->save();

        foreach ($request->input('students') as $student_id)
            $titulation_certificate->students()->attach($student_id);

        return redirect(route('titulation_certificate.show',$titulation_certificate->id))->with('success', 'Acta creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(TitulationCertificate $titulationCertificate)
    {
        //UPDATE students SET career_id = FLOOR(RAND()*9+1)

        session(['url_from' => route('titulation_certificate.show',$titulationCertificate->id)]);
        $date = $titulationCertificate->certificate_date ? Carbon::parse($titulationCertificate->certificate_date)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY') : '-';
        return view('titulation_certificate.show',['titulation_certificate' => $titulationCertificate, 'date' => $date]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TitulationCertificate $titulationCertificate)
    {
        return view('titulation_certificate.edit',['titulation_certificate' => $titulationCertificate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TitulationCertificate $titulationCertificate)
    {
        $titulationCertificate->type = $request->input('type');
        $titulationCertificate->project_name = $request->input('type') == '0' ? $request->input('project-name') : null;
        $titulationCertificate->certificate_date = $request->input('certificate-date') ? date('Y-m-d', strtotime($request->input('certificate-date'))) : null;
        $titulationCertificate->remarks = $request->input('remarks');
        $titulationCertificate->save();

        return redirect(session('url_from'))->with('success', 'Acta editada');
    }

    public function add_student(Request $request, TitulationCertificate $titulationCertificate)
    {
        if(count($titulationCertificate->students) < 3)
        {
            $titulationCertificate->students()->attach($request->input('student-id'));
            return redirect(route('titulation_certificate.show', $titulationCertificate))->with('success', 'Estudiante agregado');
        }
    }

    public function drop_student(TitulationCertificate $titulationCertificate, Student $student)
    {
        $titulationCertificate->students()->detach($student->id);
        return redirect(route('titulation_certificate.show', $titulationCertificate))->with('success', 'Estudiante sacado');
    }

    public function generate_pdf(TitulationCertificate $titulationCertificate)
    {
        $data = [
            'title' => 'Acta de Titulación',
            'titulation_certificate' => $titulationCertificate,
            'count_students' => count($titulationCertificate->students),
            'date' => $titulationCertificate->certificate_date ? Carbon::parse($titulationCertificate->certificate_date)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY') : '_____ de ______________ del _______',
        ]; 
              
        PDF::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pdf.certificate', $data);
       
        //return $pdf->download('prueba.pdf');
        return $pdf->stream();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TitulationCertificate $titulationCertificate)
    {
        //
    }
}
