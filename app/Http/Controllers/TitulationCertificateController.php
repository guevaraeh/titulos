<?php

namespace App\Http\Controllers;

use App\Models\TitulationCertificate;
use App\Models\Student;
use App\Models\Career;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TitulationCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*public function index()
    {
        session(['url_from' => route('titulation_certificate')]);
        return view('titulation_certificate.index',['titulation_certificates' => TitulationCertificate::orderBy('id', 'asc')->get()]);
    }*/

    public function index(Request $request)
    {
        /*//SELECT titulation_certificates.*, CONCAT('<li>',GROUP_CONCAT(CONCAT(students.lastname, ' ', students.name) SEPARATOR '</li><li>'),'</li>') as students FROM titulation_certificates
        SELECT titulation_certificates.*, GROUP_CONCAT(CONCAT(students.lastname, ' ', students.name) SEPARATOR ',') as students FROM titulation_certificates
        JOIN student_titulation_certificate ON titulation_certificates.id = student_titulation_certificate.titulation_certificate_id
        JOIN students ON student_titulation_certificate.student_id = students.id
        GROUP BY titulation_certificates.id*/

        session(['url_from' => route('titulation_certificate')]);
        if($request->ajax())
        {
            $titulation_certificates = TitulationCertificate::query()->orderBy('titulation_certificates.id', 'desc')
            ->select([
                DB::raw("GROUP_CONCAT(CONCAT(students.lastname, ' ', students.name) SEPARATOR ', ') as student_group"),
                'titulation_certificates.*',
            ])
            ->join('student_titulation_certificate', 'titulation_certificates.id', '=', 'student_titulation_certificate.titulation_certificate_id')
            ->join('students', 'student_titulation_certificate.student_id', '=', 'students.id')
            ->groupBy('titulation_certificates.id', 'titulation_certificates.type', 'titulation_certificates.project_name', 'titulation_certificates.remarks', 'titulation_certificates.certificate_date', 'titulation_certificates.created_at', 'titulation_certificates.updated_at')
            ;

            return DataTables::eloquent($titulation_certificates)
            /*->addColumn('students', function(TitulationCertificate $data) {
                $sts = '';
                foreach($data->students as $student)
                    $sts .= '<li>'.$student->lastname.' '.$student->name.'</li>';
                return $sts;
            })
            ->filterColumn('students', function($query, $keyword) {
                $sql = "CONCAT(students.lastname, ' ', students.name) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })*/
            ->editColumn('type', function(TitulationCertificate $data) {
                $types = ['Proyecto vinculado a formación recibida', 'Examen de suficiencia profesional'];
                return $types[$data->type];
            })
            ->editColumn('student_group', function(TitulationCertificate $data) {
                $sts = '';
                /*$students = explode(', ', $data->student_group);
                foreach($students as $student)
                    $sts .= '<li>'.$student.'</li>';*/
                foreach($data->students as $student)
                    $sts .= '<li><a href="'.route('student.show', $student->id).'">'.$student->lastname.' '.$student->name.'</a></li>';
                return $sts;
            })
            ->filterColumn('student_group', function($query, $keyword) {
                $sql = "CONCAT(students.lastname, ' ', students.name) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('actions', function(TitulationCertificate $data) {
                $actions = '
                    <a href="'.route('titulation_certificate.show', $data->id).'" class="btn btn-primary btn-sm" title="Ver">Ver</a>
                    <a href="'.route('titulation_certificate.edit', $data->id).'" class="btn btn-info btn-sm" title="Editar">Editar</a>
                    <a href="'.route('titulation_certificate.generate_pdf', $data->id).'" target="_blank" class="btn btn-secondary btn-sm" title="Pdf">PDF</a>
                ';
                return $actions;
            })
            ->rawColumns(['actions','student_group'])
            ->make(true);
        }
        return view('titulation_certificate.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('titulation_certificate.create',['students' => Student::orderBy('lastname','ASC')->get()]);

        $careers = Career::with(['students' => function (Builder $query) {
            $query->orderBy('lastname', 'asc');
        }])->get();
        //dd($careers->toArray());
        return view('titulation_certificate.create',['careers' => $careers]);
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
        return redirect(session('url_from'))->with('success', 'Estudiante sacado');
    }

    public function generate_pdf(TitulationCertificate $titulationCertificate)
    {
        $data = [
            'type' => $titulationCertificate->type,
            'project_name' => $titulationCertificate->project_name,
            'students' => $titulationCertificate->students,
            'count_students' => count($titulationCertificate->students),
            'remarks' => $titulationCertificate->remarks,
            'date' => $titulationCertificate->certificate_date ? Carbon::parse($titulationCertificate->certificate_date)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY') : '_____ de ______________ del _______',
        ];
              
        PDF::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pdf.certificate', $data);
       
        //return $pdf->download('prueba.pdf');
        return $pdf->stream();
    }

    public function generate_pdf_empty()
    {
        $data = [
            'type' => 3,
            'project_name' => null,
            'students' => [],
            'count_students' => 0,
            'remarks' => null,
            'date' => '_____ de ______________ del _______',
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
