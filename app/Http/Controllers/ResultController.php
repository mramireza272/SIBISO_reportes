<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Goal;
use App\Models\ItemValueReport;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->id){
          $result = Result::where('rol_id',$request->id)->get()->first();

          print('<div>');
          print($result->	theme_result);
          print('</div>');




            foreach ($result->formulas as $formula) {

              $valus = [];
              foreach($formula->variables as $variable){
                $valus[] = ItemValueReport::where('item_rol_id',$variable->itemrol_id)->
                                            where('item_col_id',$variable->itemstructure_id)->
                                            sum('valore');

              }

              $total_value = array_sum($valus);
              print('<div> Totales: ');
              print($total_value);
              print('</div>');

              foreach ($result->goals as $goal) {
                $dividendo = floatval($goal->goal_unit);
                print('<div>');
                print($goal->goal_txt.' &nbsp;&nbsp;&nbsp;&nbsp;');
                $percent = ($total_value / $dividendo)*100;
                print(round($percent,2).'%');
                print('</div>');
              }


            }




        }

        #$result = Result::all();
        #foreach ($result as $r) {
      #    dd($r->theme_result);
      #  }



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
