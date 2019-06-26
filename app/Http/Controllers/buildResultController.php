<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Goal;
use App\Models\ItemValueReport;
use App\Models\FormulaResult;

class buildResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->id){
          $result = Result::where('rol_id',$request->id)->get();
          
          foreach($result as $r){
	          print('<div>');
	          print('<div><b>TEMA </b>'.$r->theme_result.'</div>');
	          

	          foreach($r->goals as $goal){
	          	print('<div>META: '.$goal->goal_txt.' </div>');
	          }



	          foreach($r->formulas as $formula){
	          	print('<div>Formula '.$formula->id.' </div>');
	          }

	          print('</div>');
          }
        

	          print('<div>');
	          print('agregar tema');
	          print('</div>');



        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addresult(Request $request)
    {
        $result = Result::create([
        	'rol_id'=>$request->get('rolid'),
        	'theme_result'=>$request->get('text')
        ]);

        print($result);
    }


    public function addgoal(Request $request)
    {
    	$data = [
        	'result_id'=>$request->get('result_id'),
        	'goal_txt'=>$request->get('goal_txt'),
        	'goal_formula'=>$request->get('goal_formula'),
        	'goal_unit'=>$request->get('goal_unit')
        ];




        $result = Goal::create($data);

        print($result);
    }




    public function addformula(Request $request)
    {
        $result = FormulaResult::create([
        	'result_id'=>$request->get('resultid'),
        	'formula'=>'sum'
        ]);

        print($result);
    }



    public function rmformula(Request $request)
    {
        $result = FormulaResult::where('id',$request->get('fid'))->delete();
        print($result);
    }


    public function rmresult(Request $request)
    {
        $result = Result::where('id',$request->get('id'))->delete();
        print($result);
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
