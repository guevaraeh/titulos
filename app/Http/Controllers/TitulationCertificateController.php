<?php

namespace App\Http\Controllers;

use App\Models\TitulationCertificate;
use App\Models\Student;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TitulationCertificate $titulationCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TitulationCertificate $titulationCertificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TitulationCertificate $titulationCertificate)
    {
        //
    }
}
