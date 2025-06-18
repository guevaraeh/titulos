<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Career;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use Illuminate\Support\Str;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    /*protected $career_id;

    public function __construct() 
    {
        $this->career_id = Career::pluck('id','name')->toArray();
    }*/

    public function model(array $row)
    {
        //$career_id = Career::pluck('id','name')->toArray();
        $career = Career::select('id')->where('name',$row['carrera'])->first();
        
        return new Student([
            'name'     => $row['nombres'],
            'lastname' => $row['apellidos'],
            'dni'    => $row['dni'],
            //'career_id'     => isset($career_id[$row['carrera']]) ? $career_id[$row['carrera']] : null,
            'career_id' => $career ? $career->id : null,
            'remember_token'     => hash('sha256',  $row['dni'].time()),
        ]);
    }
}
