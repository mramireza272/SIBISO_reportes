<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\SituacionCalle\Person;
use App\Models\SituacionCalle\Sex;
use App\Models\SituacionCalle\CivilState;
use App\Models\SituacionCalle\Disability;
use App\Models\SituacionCalle\Drog;
use App\Models\SituacionCalle\Population;
use App\Models\SituacionCalle\Reason;
use App\Models\SituacionCalle\SchoolGrade;
use App\Models\SituacionCalle\State;
use App\Models\SituacionCalle\Work;
use App\Models\SituacionCalle\HumanHelp;
use App\Models\SituacionCalle\StreetTime;
use App\Models\SituacionCalle\Family;
use App\Country;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class situacioncalleExport implements FromView
{
    
    public function view(): View
        {

            $registros = Person::select('people.id','sexes.name as sexo', 'people.age as edad', 'street_times.name as street_time','people.family_id',
                            'people.drog','people.frecuence','people.hours','people.amount', 'civil_states.name as estado_civil', 
                            'people.drog_id','states.name as estado', 'disabilities.name as discapacidad', 
                            'reasons.name as razon', 'works.name as trabajo','school_grades.name as grado_escolar',
                            'populations.name as popular','people.street','people.country_id','people.colony_id','people.municipality_id','people.human_help')
                        ->leftJoin('street_times','street_times.id','=','people.street_time_id')
                        ->leftJoin('sexes','sexes.id','=','people.sex_id')
                        ->leftJoin('civil_states','civil_states.id','=','people.civil_state_id')
                        ->leftJoin('states','states.id','=','people.state_id')
                        ->leftJoin('disabilities','disabilities.id','=','people.disability_id')
                        ->leftJoin('reasons','reasons.id','=','people.reason_id')
                        ->leftJoin('works','works.id','=','people.work_id')
                        ->leftJoin('school_grades','school_grades.id','=','people.school_grade_id')
                        ->leftJoin('populations','populations.id','=','people.population_id')
                        ->get();

         
            
            return view('SituacionCalle.vista_excel.tabla', [
                'registros' => $registros
            ]);
        }


    
}
