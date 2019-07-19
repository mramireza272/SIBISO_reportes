<?php

use Illuminate\Database\Seeder;
use App\Models\ItemRol;
use App\Models\RolStructureItem;
use Spatie\Permission\Models\Role;

class ItemRolTitularSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $role = Role::findByName('Instituto para la Atención a Poblaciones Prioritarias (Titular)');

    	$mains = [
    		'CAIS',
    		'Hogar CDMX',
    		'Sistema de Servicios para el Bienestar Capital Social',
    		'Niños y Niñas fuera de peligro',
    		'Remodelaciones C.A.I.S (Ubicación)',
    		'Obra Centros de Valoración y Canalización (Ubicación)',
    		'Concepto',
    		'Concepto',
    		'Actas de Nacimiento Extemporáneas'
    	];

    	$columnsmain = [
    		'0' => ['Raciones (Alimentación)', 'Atenciones Médicas', 'Pernocta', 'Actividades Recreativas'],
    		'1' => ['Raciones', 'Atenciones Médicas', 'Personal de Enfermería', 'Actividades Recreativas'],
    		'2' => ['Tarjetas entregadas'],
    		'3' => ['Niños y Niñas atendidos'],
    		'4' => ['Por iniciar obra', 'En proceso', 'Concluida'],
    		'5' => ['Por iniciar obra', 'En proceso', 'Concluida'],
    		'6' => ['Espacio Techo'],
    		'7' => ['Unidad Móvil'],
    		'8' => ['Población en situación de calle']
    	];

    	$subs = [
    		'0' => [
    			['col' => 'Atlampa', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Azcapotzalco', 'editable' => false,'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Cascada', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Coruña Hombres', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Coruña Jóvenes', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Cuautepec', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Cuemanco', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Villa Mujeres', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Plaza del Estudiante', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Torres de Potrero', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Hogar CDMX (emergente)', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Albergue Familiar DIF-CDMX', 'editable' => false, 'subcol' => ['Hombres', 'Mujeres']]
    		],
    		'1' => [
    			['col' => 'Ingresos', 'editable' => true, 'subcol' => ['Hombres', 'Mujeres']],
    			['col' => 'Egresos', 'editable' => true, 'subcol' => ['Hombres', 'Mujeres']]
    		],
    		'2' => [
    			['col' => 'Cantidad', 'editable' => true, 'subcol' => []]
    		],
    		'3' => [
    			['col'=>'Cantidad', 'editable' => true, 'subcol' => []]
    		],
    		'4' => [
    			['col' => 'Atlampa', 'editable' => true, 'subcol' => []],
    			['col' => 'Azcapotzalco', 'editable' => true, 'subcol' => []],
    			['col' => 'Cascada', 'editable' => true, 'subcol' => []],
    			['col' => 'Coruña Hombres', 'editable' => true, 'subcol' => []],
    			['col' => 'Coruña Jóvenes', 'editable' => true, 'subcol' => []],
    			['col' => 'Cuautepec', 'editable' => true, 'subcol' => []],
    			['col' => 'Cuemanco', 'editable' => true, 'subcol'=>[]],
    			['col' => 'Villa Mujeres', 'editable' => true, 'subcol' => []],
    			['col' => 'Plaza del Estudiante', 'editable' => true, 'subcol' => []],
    			['col' => 'Torres de Potrero', 'editable' => true, 'subcol' => []],
    			['col' => 'Hogar CDMX (emergente)', 'editable' => true, 'subcol' => []],
    			['col' => 'Albergue Familiar DIF-CDMX', 'editable' => true, 'subcol' => []]
    		],
    		'5' => [
    			['col' => 'Atlampa', 'editable' => true, 'subcol' => []],
    			['col' => 'Azcapotzalco', 'editable' => true, 'subcol' => []],
    			['col' => 'Cascada', 'editable' => true, 'subcol' => []],
    			['col' => 'Coruña Hombres', 'editable' => true, 'subcol' => []],
    			['col' => 'Coruña Jóvenes', 'editable' => true, 'subcol' => []],
    			['col' => 'Cuautepec', 'editable' => true, 'subcol' => []],
    			['col' => 'Cuemanco', 'editable' => true, 'subcol' => []],
    			['col' => 'Villa Mujeres', 'editable' => true, 'subcol' => []],
    			['col' => 'Plaza del Estudiante', 'editable' => true, 'subcol' => []],
    			['col' => 'Torres de Potrero', 'editable' => true, 'subcol' => []],
    			['col' => 'Hogar CDMX (emergente)', 'editable' => true, 'subcol' => []],
    			['col' => 'Albergue Familiar DIF-CDMX', 'editable' => true, 'subcol' => []]
    		],
    		'6' => [
    			['col' => 'No. de talleres realizados (oficios,terapia ocupacional,salud emocional,adicciones)', 'editable' => true, 'subcol'=>[]],
    			['col' => 'No. de asistentes', 'editable' => true, 'subcol' => []],
    			['col' => 'No. de reuniones comunidades de apoyo', 'editable' => true, 'subcol' => []],
    			['col' => 'No. de participantes', 'editable' => true, 'subcol' => []],
    			['col' => 'No. de planes de vida elaborados', 'editable' => true, 'subcol' => []],
    		],
    		'7' => [
    			['col' => 'No. puntos visitados (incluir cuales)', 'editable' => true, 'subcol' => []],
    			['col' => 'No. atenciones y tipo', 'editable' => true, 'subcol' => []],
    		],
    		'8' => [
    			['col' => 'Hombres', 'editable' => true, 'subcol' => []],
    			['col' => 'Mujeres', 'editable' => true, 'subcol' => []]
    		]
    	];

    	$order = 0;

    	foreach ($mains as $key => $value) {
	    	$itemrol = ItemRol::create([
	    		'rol_id' => $role->id,
	    		'item' => $value,
	    		'parent_id' => null,
	    		'editable' => false,
	    		'order' => $key
	    	]);

	    	foreach ($columnsmain[$order] as $ckey => $cvalue) {
		    	$itemstruct = RolStructureItem::create([
		    		'item_rol_id' => $itemrol->id,
		    		'columns' => $cvalue,
		    		'order' => $order
		    	]);
	    	}

	    	$suborder = 0;

	    	foreach ($subs[$order] as $subkey => $subvalue) {
		    	$subitemrol = ItemRol::create([
		    		'rol_id' => $role->id,
		    		'item' => $subvalue['col'],
		    		'parent_id' => $itemrol->id,
		    		'editable' => $subvalue['editable'],
		    		'order' => $suborder
		    	]);

		    	$subsuborder = 0;

		    	foreach ($subvalue['subcol'] as $subbval) {
			    	$subsubitemrol = ItemRol::create([
			    		'rol_id' => $role->id,
			    		'item' => $subbval,
			    		'parent_id' => $subitemrol->id,
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