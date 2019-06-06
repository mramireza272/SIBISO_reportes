<?php

use Illuminate\Database\Seeder;
use App\Models\ItemRol;
use App\Models\RolStructureItem;
use Spatie\Permission\Models\Role;

class ItemRolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	$role = Role::findByName('Instituto para la Atención a Poblaciones Prioritarias');

    	dd($role);

    	$mains = [
    			'CAAIS',
    			'Hogar CDMX',
    			'Sistema de Servicios para el Bienestar Capital Social',
    			'Niños y Niñas fuera de peligro',
    			'Remodelaciones C.A.I.S (Ubicación)',
    			'Obra Centros de Valoración y Canalización (Ubicación)',
    			'Concepto',
    			'Actas de Nacimiento Extemporáneas'
    			];

    	$columnsmain = ['0'=>['Raciones (Alimentación)','Atenciones Médicas','Pernocata','Actividades Recreativas'],
    		'1'=>['Raciones','Atenciones Médicas','Personal de Enfermería','Actividades Recreativas'],
    		'2'=>['Tarjetas entregadas'],
    		'3'=>['Niños y Niñas atendidos'],
    		'4'=>['Por iniciar obra','En proceso','Concluida','Ninguna'],
    		'5'=>['Por iniciar obra','En proceso','Concluida','Ninguna'],
    		'6'=>['Unicación','Cantidad'],
    		'7'=>['Cantidad','Población en situación de calle']
    	];

    	$subs = [
    		'0'=>[
    			['col'=>'Atlapma','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Atzapotzalco','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Cascada','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Coruña Hombres','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Coruña jovenes','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Cuautepec','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Cuemanco','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Villa Mujeres','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Plaza del Estudiante','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Torres de Potrero','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Hogar CDMX (emergente)','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Albergue Familiar DIF-CDMX','subcol'=>['Hombres','Mujeres']]

    		],
    		'1'=>[
    			['col'=>'Ingresos','subcol'=>['Hombres','Mujeres']],
    			['col'=>'Egresos','subcol'=>['Hombres','Mujeres']]
    		],
    		'2'=>[
    		['col'=>'Cantidad','subcol'=>[]]
    		],
    		'3'=>[
    			['col'=>'Cantidad','subcol'=>[]]
    		],
    		'4'=>[
    			['col'=>'Atlapma','subcol'=>[]],
    			['col'=>'Atzapotzalco','subcol'=>[]],
    			['col'=>'Cascada','subcol'=>[]],
    			['col'=>'Coruña Hombres','subcol'=>[]],
    			['col'=>'Coruña jovenes','subcol'=>[]],
    			['col'=>'Cuautepec','subcol'=>[]],
    			['col'=>'Cuemanco','subcol'=>[]],
    			['col'=>'Villa Mujeres','subcol'=>[]],
    			['col'=>'Plaza del Estudiante','subcol'=>[]],
    			['col'=>'Torres de Potrero','subcol'=>[]],
    			['col'=>'Hogar CDMX (emergente)','subcol'=>[]],
    			['col'=>'Albergue Familiar DIF-CDMX','subcol'=>[]]
    		],
    		'5'=>[
    			['col'=>'Atlapma','subcol'=>[]],
    			['col'=>'Atzapotzalco','subcol'=>[]],
    			['col'=>'Cascada','subcol'=>[]],
    			['col'=>'Coruña Hombres','subcol'=>[]],
    			['col'=>'Coruña jovenes','subcol'=>[]],
    			['col'=>'Cuautepec','subcol'=>[]],
    			['col'=>'Cuemanco','subcol'=>[]],
    			['col'=>'Villa Mujeres','subcol'=>[]],
    			['col'=>'Plaza del Estudiante','subcol'=>[]],
    			['col'=>'Torres de Potrero','subcol'=>[]],
    			['col'=>'Hogar CDMX (emergente)','subcol'=>[]],
    			['col'=>'Albergue Familiar DIF-CDMX','subcol'=>[]]
    		],
    		'6'=>[
    			['col'=>'No. de talleres realizados (oficios,terapia ocupacional,salud emocional,adicciones)','subcol'=>[]],
    			['col'=>'No. de asistentes','No. de reuniones comunidades de apoyo','subcol'=>[]],
    			['col'=>'No. de participantes','subcol'=>[]],
    			['col'=>'No. de planes de vida elaborados','subcol'=>[]],
    			['col'=>'No. puntos visitados (incluir cuales)','subcol'=>[]],
    			['col'=>'No. atenciones y tipo','subcol'=>[]],

    		],
    		'7'=>[
    			['col'=>'Hombres','subcol'=>[]],
    			['col'=>'Mujeres','subcol'=>[]],

    		]
    	];

    	$order=0;
    	foreach ($mains as $key => $value) {
	    	$itemrol = ItemRol::create(['rol_id' => 1,
	        				 'item'   => $value,
	        				 'parent_id' =>null,
	        				 'editable' => false,
	        				 'order' => $key
	    	]);
	    	
	    	foreach ($columnsmain[$order] as $ckey => $cvalue) {
		    	$itemstruct = RolStructureItem::create(['item_rol_id' => $itemrol->id,
		        				 'columns'   => $cvalue,
		        				 'order'=>$order
		    	]);

	    	}

	    	$suborder = 0;
	    	foreach ($subs[$order] as $subkey => $subvalue) {

		    	$subitemrol = ItemRol::create(['rol_id' => 1,
		        				 'item'   => $subvalue['col'],
		        				 'parent_id' =>$itemrol->id,
		        				 'editable' => true,
		        				 'order' => $suborder
		    	]);

		    	$subsuborder=0;
		    	foreach ($subvalue['subcol'] as $subbval) {
			    	$subsubitemrol = ItemRol::create(['rol_id' => 1,
			        				 'item'   => $subbval,
			        				 'parent_id' =>$subitemrol->id,
			        				 'editable' => true,
			        				 'order' => $subsuborder
			    	]);
			    	$subsuborder++;

		    	}

		    $suborder++;



	    	}



	    	$order++;

    	}



    }
}
