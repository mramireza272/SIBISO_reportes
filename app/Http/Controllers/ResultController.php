<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Goal;
use App\Models\Report;
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
          $result = Result::where('rol_id', $request->id)->with('formulas')->get();
          //$result = Result::all();
          //dd($result);

        foreach ($result as $result) {
             print('<div>');
          print($result->theme_result);
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
        //el ver más
        $valus[] = Report::where('rol_id',$variable->rol_id)->
                           where('between de las fechas que elija')->with('childs')->get();

        //hay que hacer un foreach de los childs y todos sus values se van a tratar como el valus


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
