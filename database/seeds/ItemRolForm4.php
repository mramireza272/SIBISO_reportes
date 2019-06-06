<?php

use Illuminate\Database\Seeder;
use App\Models\ItemRol;
use App\Models\RolStructureItem;
use Spatie\Permission\Models\Role;

class ItemRolForm4 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
    	$role = Role::findByName('Subsecretaría de Derechos Humanos');

    	if($role->exists){
	    	$mains = ['Acciones a reportar'];
	    	$columnsmain = ['0'=>['Cantidad']];

	    	$subs = [
	    		'0'=>[
	    			['col'=>'Foros y Conservatorios','subcol'=>[]],
	    			['col'=>'Capacitación sobre DDHH y diversidad sexual a personas operadoras de LOCALTEL','subcol'=>[]],
	    			['col'=>'Lunes de educación para la Paz','subcol'=>[]]

	    		]
	    	];

    	
    	$order=0;
    	foreach ($mains as $key => $value) {
	    	$itemrol = ItemRol::create(['rol_id' => $role->id,
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

		    	$subitemrol = ItemRol::create(['rol_id' => $role->id,
		        				 'item'   => $subvalue['col'],
		        				 'parent_id' =>$itemrol->id,
		        				 'editable' => true,
		        				 'order' => $suborder
		    	]);

		    	$subsuborder=0;
		    	foreach ($subvalue['subcol'] as $subbval) {
			    	$subsubitemrol = ItemRol::create(['rol_id' => $role->id,
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
    	else{
    		dd('no hay role parole');
    	}

        //
    


    }
}
