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
            ->with('students')
            /*->with(['students' => function (Builder $query) {
                $query->orderBy('lastname', 'asc');
            }])*/
            ;

            return DataTables::eloquent($titulation_certificates)
            ->editColumn('type', function(TitulationCertificate $data) {
                $types = ['Proyecto vinculado a formación recibida', 'Examen de suficiencia profesional'];
                //$types = [$data->project_name, 'Examen de suficiencia profesional'];
                return $types[$data->type];
            })
            ->editColumn('project_name', function(TitulationCertificate $data) {
                if($data->project_name)
                    return $data->project_name;
                    //return $project_name; //para que de la pantalla de cargando
                return '-';
            })
            ->addColumn('student_group', function(TitulationCertificate $data) {
                $sts = '';
                if(count($data->students) > 0)
                {
                    $loop = 0;
                    foreach($data->students as $student)
                    {
                        if($loop > 0) $sts .= '<br>';
                        $sts .= '<a href="'.route('student.show', $student->id).'">'.$student->lastname.' '.$student->name.'</a>';
                        $loop++;
                    }
                }
                return $sts;
            })
            ->filterColumn('student_group', function($query, $keyword) {
                /*$sql = "CONCAT(students.lastname, ' ', students.name) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);*/
                /*$query->whereHas('students', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });*/
                $query->whereHas('students', function ($q) use ($keyword) {
                    $q->whereRaw("CONCAT(students.lastname, ' ', students.name) like ?", "%{$keyword}%");
                });
            })
            ->addColumn('actions', function(TitulationCertificate $data) {
                $actions = '
                <div class="btn-group" role="group">
                    <a href="'.route('titulation_certificate.show', $data->id).'" class="btn btn-primary" title="Ver"><i class="bi-eye"></i></a>
                    <a href="'.route('titulation_certificate.edit', $data->id).'" class="btn btn-info" title="Editar"><i class="bi-pencil"></i></a>
                    <a href="'.route('titulation_certificate.generate_pdf', $data->id).'" target="_blank" class="btn btn-secondary" title="Pdf"><i class="bi-file-earmark-pdf"></i></a>
                    <button type="button" class="btn btn-danger swalDefaultSuccess" form="deleteall" formaction="'.route('titulation_certificate.destroy',$data->id).'" value="" title="Eliminar"><i class="bi-trash"></i></button>
                </div>
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
        $careers = Career::select('id','name')->get();
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
        $titulation_certificate->remember_token = hash('sha256', date('Y-m-d H:i:s', time()));
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

        /*$titulationCertificate = $titulationCertificate->with(['students' => function (Builder $query) {
                                                        $query->orderBy('lastname', 'asc');
                                                    }])->get();*/

        return view('titulation_certificate.show',['titulation_certificate' => $titulationCertificate, 'date' => $date, 'careers' => Career::get()]);
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
        $limit_p = 75;
        $project_name = ['', ''];

        if (strlen($titulationCertificate->project_name) <= $limit_p)
            $project_name[0] = $titulationCertificate->project_name;
        else
        {
            $pos = strrpos(substr($titulationCertificate->project_name, 0, $limit_p), ' ');
            if ($pos === false)
                $pos = $limit_p;

            $part1 = trim(substr($titulationCertificate->project_name, 0, $pos));
            $part2 = trim(substr($titulationCertificate->project_name, $pos));

            $project_name = [$part1, $part2];
        }

        $limit_r = 85;
        $remarks = ['', ''];

        if (strlen($titulationCertificate->remarks) <= $limit_r)
            $remarks[0] = $titulationCertificate->remarks;
        else
        {
            $pos = strrpos(substr($titulationCertificate->remarks, 0, $limit_r), ' ');
            if ($pos === false)
                $pos = $limit_r;

            $part1 = trim(substr($titulationCertificate->remarks, 0, $pos));
            $part2 = trim(substr($titulationCertificate->remarks, $pos));

            $remarks = [$part1, $part2];
        }

        //dd($project_name);
        

        $data = [
            'type' => $titulationCertificate->type,
            //'project_name' => $titulationCertificate->project_name,
            'project_name' => $project_name,
            'students' => $titulationCertificate->students,
            'count_students' => count($titulationCertificate->students),
            //'remarks' => $titulationCertificate->remarks,
            'remarks' => $remarks,
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
            'project_name' => ['', ''],
            'students' => [],
            'count_students' => 0,
            'remarks' => ['', ''],
            'date' => '_____ de ______________ del _______',
        ];
              
        //PDF::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pdf.certificate', $data);
        /*$pdf = PDF::setOptions(['isRemoteEnabled' => true])
              ->loadView('pdf.certificate', $data);*/
       
        //return $pdf->download('prueba.pdf');
        return $pdf->stream();
    }

    public function create_fast()
    {
        $careers = Career::select('id','name')->get();
        return view('titulation_certificate.create_fast',['careers' => $careers]);
    }
    
    public function generate_pdf_fast(Request $request)
    {
        $limit_p = 75;
        $project_name = ['', ''];

        if (strlen($request->input('project-name')) <= $limit_p)
            $project_name[0] = $request->input('project-name');
        else
        {
            $pos = strrpos(substr($request->input('project-name'), 0, $limit_p), ' ');
            if ($pos === false)
                $pos = $limit_p;

            $part1 = trim(substr($request->input('project-name'), 0, $pos));
            $part2 = trim(substr($request->input('project-name'), $pos));

            $project_name = [$part1, $part2];
        }

        $limit_r = 85;
        $remarks = ['', ''];

        if (strlen($request->input('remarks')) <= $limit_r)
            $remarks[0] = $request->input('remarks');
        else
        {
            $pos = strrpos(substr($request->input('remarks'), 0, $limit_r), ' ');
            if ($pos === false)
                $pos = $limit_r;

            $part1 = trim(substr($request->input('remarks'), 0, $pos));
            $part2 = trim(substr($request->input('remarks'), $pos));

            $remarks = [$part1, $part2];
        }

        $data = [
            'type' => $request->input('type'),
            'project_name' => $project_name,
            'students' => $request->input('students'),
            'count_students' => count($request->input('students')),
            'remarks' => $remarks,
            'date' => $request->input('certificate-date') ? Carbon::parse($request->input('certificate-date'))->locale('es')->isoFormat('DD [de] MMMM [del] YYYY') : '_____ de ______________ del _______',
        ];
              
        PDF::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pdf.certificate', $data);
       
        //return $pdf->download('prueba.pdf');
        return $pdf->stream();        
    }

    public function search_certificates()
    {
        //dd(time(), hash('sha256', time()), date('Y-m-d H:i:s', time()), hash('sha256', date('Y-m-d H:i:s', time())));

        $careers = Career::select('id','name')->get();
        return view('titulation_certificate.search_certificates',['careers' => $careers]);
    }

    public function get_certificates_ajax(Request $request)
    {
        if($request->ajax())
        {
            $student = Student::find($request->input('student_id'));
            return response()->view('ajax.get_certificates', ['titulation_certificates' => $student->titulation_certificates]);
        }
    }

    public function certificate($data)
    {
        $titulationCertificate = TitulationCertificate::where('remember_token' , $data)->firstOrFail();
        
        $limit_p = 75;
        $project_name = ['', ''];

        if (strlen($titulationCertificate->project_name) <= $limit_p)
            $project_name[0] = $titulationCertificate->project_name;
        else
        {
            $pos = strrpos(substr($titulationCertificate->project_name, 0, $limit_p), ' ');
            if ($pos === false)
                $pos = $limit_p;

            $part1 = trim(substr($titulationCertificate->project_name, 0, $pos));
            $part2 = trim(substr($titulationCertificate->project_name, $pos));

            $project_name = [$part1, $part2];
        }

        $limit_r = 85;
        $remarks = ['', ''];

        if (strlen($titulationCertificate->remarks) <= $limit_r)
            $remarks[0] = $titulationCertificate->remarks;
        else
        {
            $pos = strrpos(substr($titulationCertificate->remarks, 0, $limit_r), ' ');
            if ($pos === false)
                $pos = $limit_r;

            $part1 = trim(substr($titulationCertificate->remarks, 0, $pos));
            $part2 = trim(substr($titulationCertificate->remarks, $pos));

            $remarks = [$part1, $part2];
        }

        //dd($project_name);
        

        $data = [
            'type' => $titulationCertificate->type,
            //'project_name' => $titulationCertificate->project_name,
            'project_name' => $project_name,
            'students' => $titulationCertificate->students,
            'count_students' => count($titulationCertificate->students),
            //'remarks' => $titulationCertificate->remarks,
            'remarks' => $remarks,
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
        foreach($titulationCertificate->students as $student)
            $titulationCertificate->students()->detach($student->id);
        $titulationCertificate->delete();
        return redirect(route('titulation_certificate'))->with('success', 'Acta eliminada');
    }
}
