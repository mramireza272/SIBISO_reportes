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

class CreateFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {

        $items = ItemRol::where('rol_id',$id)->where('parent_id',null)->orderBy('order')->get();
        print('<table>');
        foreach ($items as $itm) {
        	print('<tr>');

        	print('<td>');
        	print('<input type="text" name="" value="'.$itm->item.'">');
        	if($itm->editable)
        	print($itm->editable);
        	else
        	print('0');
        	print('</td>');


        	foreach ($itm->cols as $col) {
	        	print('<td class="col-form">');
	        	print('<input type="text" name="col_'.$col->id.'" value="'.$col->columns.'">');
	        	print('</td>');
        	}



        	# PARA EL BOTON DE AREGAR COLUMNA
        	if(!$itm->editable)
        	{
	        	print('<td>');
	        	print('<a href="#addCol">'.$itm->id.'[+]</a>');
	        	print('</td>');
	        }

        	print('</tr>');


        	foreach ($itm->childs as $subitm) {
        		print('<tr>');
	        	print('<td style="padding:0px 12px;">');
	        	print('<input type="text" name="" value="'.$subitm->item.'">');
	        	print('</td>');
	        	print('</tr>');

        	}

        }

        print('</table>');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function create()
    {
    	#

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
