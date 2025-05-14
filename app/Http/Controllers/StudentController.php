<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Contracts\Database\Eloquent\Builder;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        session(['url_from' => route('student')]);

        if($request->ajax())
        {
            $students = Student::query()->orderBy('lastname','ASC')
            ->select([DB::raw("careers.name as career"),'students.*'])
            ->join('careers', 'students.career_id', '=', 'careers.id');

            return DataTables::eloquent($students)
            ->addColumn('actions', function(Student $data) {
                $actions = '
                <div class="btn-group" role="group">
                    <a href="'.route('student.show', $data->id).'" class="btn btn-primary" title="Ver"><i class="bi-eye"></i></a>
                    <a href="'.route('student.edit', $data->id).'" class="btn btn-info" title="Editar"><i class="bi-pencil"></i></a>
                    <button type="button" class="btn btn-danger swalDefaultSuccess" form="deleteall" formaction="'.route('student.destroy',$data->id).'" value="'. $data->lastname .' '. $data->name .'" title="Eliminar"><i class="bi-trash"></i></button>
                </div>
                ';
                return $actions;
            })
            ->editColumn('photo', function(Student $data) {
                return '<img src="'.asset($data->photo ? 'storage/'.$data->photo : 'no-photo.png').'" height="40"  width="30">';
            })
            ->editColumn('career', function(Student $data) {
                return $data->career;
            })
            ->filterColumn('career', function($query, $keyword) {
                $sql = "careers.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['actions','photo'])
            ->make(true);
        }

        //return view('student.index',['students' => Student::get()]);
        return view('student.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create',['careers' => Career::get()]);
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
        $student->career_id = $request->input('career-id');

        if($request->hasFile('photo'))
        {
            $imageName = time().'.'.$request->file('photo')->extension();  
            $request->file('photo')->move(public_path('storage'), $imageName);
            $student->photo = $imageName;
        }

        $student->save();

        return redirect(route('student.show',$student->id))->with('success', 'Alumno registrado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        session(['url_from' => route('student.show',$student->id)]);
        return view('student.show',['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('student.edit',['student' => $student, 'careers' => Career::get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $student->name = $request->input('name');
        $student->lastname = $request->input('lastname');
        $student->dni = $request->input('dni');
        $student->career_id = $request->input('career-id');

        if($request->hasFile('photo'))
        {
            $imageName = time().'.'.$request->file('photo')->extension();  
            $request->file('photo')->move(public_path('storage'), $imageName);
            $student->photo = $imageName;
        }

        $student->save();

        return redirect(session('url_from'))->with('success', 'Alumno editado');
    }

    public function get_students_ajax(Request $request)
    {
        if($request->ajax())
        {
            //$careers = Career::get();

            $students = Student::select('id','name','lastname');
            foreach($request->input('selected_students') as $st)
                $students->where('id','<>',$st);
            $students = $students->orderBy('lastname', 'asc')->get();
            return response()->json($students);
        }
    }

    public function get_students_by_career_ajax(Request $request)
    {
        if($request->ajax())
        {
            $students = Student::select('id','name','lastname','career_id')
            ->where('career_id', $request->input('career'))
            ->orderBy('lastname', 'asc');
            if($request->input('selected_students'))
            {
                foreach($request->input('selected_students') as $st)
                    $students->where('id','<>',$st);
            }
            $students = $students->get();
            return response()->json($students);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        foreach($student->titulation_certificates as $titulation_certificate)
            $titulation_certificate->students()->detach($student->id);
        $student->delete();
        return redirect(route('student'))->with('success', 'Estudiante eliminado');
    }
}
