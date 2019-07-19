<?php

use Illuminate\Database\Seeder;
use App\Models\ItemRol;
use App\Models\RolStructureItem;
use Spatie\Permission\Models\Role;

class ItemRolForm1 extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
    	$role = Role::findByName('Instituto para el Envejecimiento Digno');

    	if($role->exists) {
	    	$mains = ['Acciones a reportar'];
	    	$columnsmain = ['0' => ['Cantidad']];

        	$subs = [
        		'0'=>[
        			['col' => 'Visitas Médicas SALUD EN TU VIDA', 'editable' => true, 'subcol' => []],
        			['col' => 'Atención brindada (Análisis)', 'editable' => true, 'subcol' => []],
        			['col' => 'Atención brindada (Emocional / Mental)', 'editable' => true, 'subcol' => []],
        			['col' => 'Atención brindada (Translado hospitalario)', 'editable' => true, 'subcol' => []],
        			['col' => 'Atención incidentes de violencia', 'editable' => true, 'subcol' => []],
        			['col' => 'Incidentes abandono', 'editable' => true, 'subcol' => []],
        			['col' => 'Reportes ciudadanos atendidos', 'editable' => true, 'subcol' => []],
        			['col' => 'Participaciones en turismo social foráneo', 'editable' => true, 'subcol' => []],
        			['col' => 'Participaciones en turismo social Sonrisas', 'editable' => true, 'subcol' => []],
        			['col' => 'Establecimiento de CASSA', 'editable' => true, 'subcol' => []],
        			['col' => 'Atención y Orientación de Alzheimer y otras Demencias en Iztacalco', 'editable' => true, 'subcol' => []],
        			['col' => 'Atención en el centro de Día, Alzheimer México en Tlalpan', 'editable' => true, 'subcol' => []],
        			['col' => 'Visitas Domiciliarias', 'editable' => true, 'subcol' => []],
        			['col' => 'Centro de formación integral ocupacional e inserción laboral voluntaria', 'editable' => true, 'subcol' => []],
        			['col' => 'Talleres', 'editable' => true, 'subcol' => []],
        			['col' => 'Colocaciones', 'editable' => true, 'subcol' => []],
        			['col' => 'No. casos PROCU', 'editable' => true, 'subcol' => []],
    				['col' => 'Atenciones Gerontológicas', 'editable' => true, 'subcol' => []],
    				['col' => 'Atenciones del Sistema de Alerta Social', 'editable' => true, 'subcol' => []]
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
                        'editable' => true,
                        'order' => $suborder
    		    	]);

    		    	$subsuborder = 0;

    		    	foreach ($subvalue['subcol'] as $subbval) {
    			    	$subsubitemrol = ItemRol::create([
                            'rol_id' => $role->id,
                            'item' => $subbval,
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
    	} else {
    		dd('no hay role parole');
    	}
    }
}