<?php

namespace App\Http\Controllers;

use App\Models\TitulationCertificate;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TitulationCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('titulation_certificate.index',['titulation_certificates' => TitulationCertificate::orderBy('id', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('titulation_certificate.create',['students' => Student::get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->collect());
        $titulation_certificate = new TitulationCertificate;
        $titulation_certificate->type = $request->input('type');
        $titulation_certificate->project_name = $request->input('project-name');
        $titulation_certificate->certificate_date = date('Y-m-d', strtotime($request->input('certificate-date')));
        $titulation_certificate->remarks = $request->input('remarks');
        $titulation_certificate->save();

        foreach ($request->input('students') as $student_id)
            $titulation_certificate->students()->attach($student_id);

        return redirect(route('titulation_certificate'))->with('success', 'Acta creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(TitulationCertificate $titulationCertificate)
    {
        $students = Student::select('id','name','lastname');
        foreach($titulationCertificate->students as $st)
            $students->where('id','<>',$st->id);
        $students = $students->get();
        //dd($students);

        $date = Carbon::parse($titulationCertificate->certificate_date)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY');
        return view('titulation_certificate.show',['titulation_certificate' => $titulationCertificate, 'date' => $date, 'students' => $students]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TitulationCertificate $titulationCertificate)
    {
        session(['previous_url' => url()->previous()]);
        return view('titulation_certificate.edit',['titulation_certificate' => $titulationCertificate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TitulationCertificate $titulationCertificate)
    {
        $titulationCertificate->type = $request->input('type');
        $titulationCertificate->project_name = $request->input('project-name');
        $titulationCertificate->certificate_date = date('Y-m-d', strtotime($request->input('certificate-date')));
        $titulationCertificate->remarks = $request->input('remarks');
        $titulationCertificate->save();

        return redirect(session('previous_url'))->with('success', 'Acta editada');
    }

    public function add_student(Request $request, TitulationCertificate $titulationCertificate)
    {
        $titulationCertificate->students()->attach($request->input('student-id'));
        return redirect(route('titulation_certificate.show', $titulationCertificate))->with('success', 'Estudiante agregado');
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
        ]; 
              
        //$pdf = PDF::loadView('myPDF', $data);
       
        //return $pdf->download('acta.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TitulationCertificate $titulationCertificate)
    {
        //
    }
}
