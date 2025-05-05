<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('student.index',['students' => Student::get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*$request->validate([
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'dni' => 'required|max:255',
            'career' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048', // Max 2MB
        ]);*/

        //dd($request->hasFile('photo'));

        $student = new Student;
        $student->name = $request->input('name');
        $student->lastname = $request->input('lastname');
        $student->dni = $request->input('dni');
        $student->career = $request->input('career');

        if($request->hasFile('photo'))
        {
            $imageName = time().'.'.$request->file('photo')->extension();  
            $request->file('photo')->move(public_path('storage'), $imageName);
            $student->photo = $imageName;
        }

        $student->save();

        return redirect(route('student'))->with('success', 'Alumno registrado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('student.show',['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        session(['previous_url' => url()->previous()]);
        return view('student.edit',['student' => $student, 'previous' => session('previous_url')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $student->name = $request->input('name');
        $student->lastname = $request->input('lastname');
        $student->dni = $request->input('dni');
        $student->career = $request->input('career');

        if($request->hasFile('photo'))
        {
            $imageName = time().'.'.$request->file('photo')->extension();  
            $request->file('photo')->move(public_path('storage'), $imageName);
            $student->photo = $imageName;
        }

        $student->save();

        return redirect(session('previous_url'))->with('success', 'Alumno editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
