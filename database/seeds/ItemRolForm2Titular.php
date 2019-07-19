<?php

use Illuminate\Database\Seeder;
use App\Models\ItemRol;
use App\Models\RolStructureItem;
use Spatie\Permission\Models\Role;

class ItemRolForm2Titular extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $role = Role::findByName('Coordinación General de Inclusión y Bienestar (Titular)');

    	if($role->exists) {
	    	$mains = ['Acciones a reportar'];
	    	$columnsmain = ['0' => ['Cantidad']];

	    	$subs = [
	    		'0' => [
	    			['col'=>'Actas de nacimiento extemporáneas', 'editable' => false, 'subcol' => []],
	    			['col'=>'Personas Mayores ', 'editable' => false, 'subcol' => [
	    				['name' => 'Hombres', 'editable' => true],
	    			 	['name' => 'Mujeres', 'editable' => true]
	    			]],
	    			['col' => 'Personas Indígenas', 'editable' => false, 'subcol' => [
	    			 	['name' => 'Hombres', 'editable' => true],
	    			 	['name' => 'Mujeres', 'editable' => true]
	    			]],
	    			['col' => 'Alianzas con empresas de entretenimiento', 'editable' => true, 'subcol' => []],
	    			['col' => 'Alianzas con universidades públicas y privadas', 'editable' => true, 'subcol' => []],
	    			['col' => 'Convenios de colaboración y coordinación', 'editable' => true, 'subcol'=>[]]
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
				    		'item' => $subbval['name'],
				    		'parent_id' => $subitemrol->id,
				    		'editable' => $subbval['editable'],
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