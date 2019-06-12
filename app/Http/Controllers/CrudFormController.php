<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use \Spatie\Permission\Models\Permission;
use \Spatie\Permission\Models\Role;
use App\Models\ItemRol;
use App\Models\Report;
use App\Models\RolStructureItem;
use App\Models\ItemValueReport;
use Auth;

class CrudFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$whre,$id)
    {

      # PARA CREAR UNA COLUMNA DEBERAS USAR UNA ESTRUCTRA DE URL DEL TIPO
    	# /add/col/ITEMROL_ID/

    	if($whre=='col'){
    		$todos = RolStructureItem::all();
    		$added = RolStructureItem::create([
    			'item_rol_id'=>$id,
    			'order'=>count($todos),
    			'columns'=>' nueva columna'
    		]);
    		dd('col created succesfuly');
    	}

    	#PARA AGREGAR UN RENGLON DEBERAS USAR LA ESTRUCTURA SIGUIETE
    	# add/row/ROL_ID/?parent=ITEMROLID

    	if($whre=='row'){
    		
    		$parent = $request->get('parent');
    		$todos = ItemRol::all();
    		$added = ItemRol::create([
    			'rol_id'=>$id,
    			'parent_id'=>$parent,
    			'order'=>count($todos),
    			'item'=>' nuevo renglon',
    			'editable'=>false
    		]);
    		dd('rol created succesfuly');
    	}



    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    #para actualizar un campo, solo es necesario pasar el ID directo y el valor; ejemplo

    # /update/78/?item=Texto

    public function update(Request $request,$whre,$id)
    {
        $item_value = $request->get('item');
    	if($whre=='col'){
    		
    		$item = RolStructureItem::find($id);
    		$item->columns=$item_value;
    		$item->save();
    	}

    	if($whre=='row'){
    		
    		$item = ItemRol::find($id);
    		$item->item=$item_value;
    		$item->save();
    	}        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    # Para eliminar una columna o un renglon 
    # deberas mandar la url con el tipo de elemento que deseas eliminar, por ejemplo
    #ROW
    # /rm/row/ID
    # /rm/col/ID

    public function destroy(Request $request,$whre,$id)
    {

    	if($whre=='col'){
    		
    		$item = RolStructureItem::find($id);
    		$item->delete();
    		dd('col removed succesfuly');
    	}

    	if($whre=='row'){
    		
    		$item = ItemRol::find($id);
    		if($item)
    			$item->delete();
    		dd($item);
    	}
        

    }
}
