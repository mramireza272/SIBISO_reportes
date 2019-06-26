<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\FormulaResult;
use App\Models\VariableFormula;
use App\Models\ItemRol;



class buildFormulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    	$rows = ItemRol::where('rol_id',$request->rolid)->where('parent_id',null)->get();
    	$formula = $result = FormulaResult::where('id',$request->formulaid)->get()->first();

    	$actives = [];
    	foreach($formula->variables as $fova){
    		$actives[$fova->itemrol_id][$fova->itemstructure_id]='checked';
    	}



    	print('<form action="/savevariables/" method="get">');
		print('<input type="hidden" name="formulaid" value="'.$request->formulaid.'">');
    	print('<table>');

    	foreach($rows as $row){
    		print('<tr><td>');
	    		print($row->item);
    		print('</td>');


    		foreach($row->cols as $col){
    			print('<td>'.$col->columns.'</td>');
    		}

    		print('</tr>');

    		foreach($row->childs as $ch){
    			print('<tr>');
    			print('<td>'.$ch->item);

		    		foreach($row->cols as $innercol){
		    		print('<td>');
		    			if(isset($actives[$ch->id][$innercol->id]))
		    				$checked = 'checked="true"';
		    				
		    			else
		    				$checked = '';
		  			if($ch->editable==true)
		  			print('<input type="checkbox" name="check_'.$ch->id.'[]"  value="'.$ch->id.'_'.$innercol->id.'"   '.$checked.' /></td>');	

		    		}
		    	print('</td>');

    			print('</tr>');
	    		foreach($ch->childs as $sbch){
	    			print('<tr>');
	    			print('<td>'.$sbch->item);

	    			print('</td>');

		    		foreach($row->cols as $innercol){
		    		print('<td>');
		    			if(isset($actives[$sbch->id][$innercol->id]))
		    				$checked = 'checked="true"';
		    				
		    			else
		    				$checked = '';
		  			print('<input type="checkbox" name="check[]"  value="'.$sbch->id.'_'.$innercol->id.'" '.$checked.' /></td>');	

		    		}


	    			
	    			print('</tr>');
	    		}




    		}





    	}

    	print('<tr><td><input type="submit" value="SAVE IT" /></td></tr>');

    	print('</table></form>');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$variables = VariableFormula::where('formula_id',$request->get('formulaid'))->delete();
    	
    	foreach($request->get('check') as $variable){
    		$pices = explode('_',$variable);
    		var_dump($pices);
    		$newvariable = VariableFormula::create([
    			'formula_id'=>$request->get('formulaid'),
    			'itemrol_id'=>$pices[0],
    			'itemstructure_id'=>$pices[1]
    		]);
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
