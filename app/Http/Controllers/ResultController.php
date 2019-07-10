<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Goal;
use App\Models\Report;
use App\Models\ItemValueReport;
use \Spatie\Permission\Models\Role;
use Validator;

class ResultController extends Controller {
    function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:index_form')->only('index');
        $this->middleware('permission:show_form')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //dd($request->all());
        $roles = Role::all()->sortBy('name')->except(1);
        //$results = Result::orderBy('rol_id')->get();
        $results = Result::all()->sortBy('rol_id')->sortBy('theme_result');
        $reports = [];
        $role_id = '';

        foreach ($results as $result) {
            $report['id'] = $result->id;
            $report['role'] = $result->rol->name;
            $report['theme_result'] = $result->theme_result;

            foreach ($result->formulas as $formula) {
                $valus = [];

                foreach($formula->variables as $variable){
                    $valus[] = ItemValueReport::where([
                        ['item_rol_id', $variable->itemrol_id],
                        ['item_col_id', $variable->itemstructure_id]
                    ])->sum('valore');
                }

                $report['total_value'] = number_format(array_sum($valus));
                $goals = [];

                foreach ($result->goals as $goal) {
                    $dividendo = floatval($goal->goal_unit);
                    $each_goal['goal_txt'] = $goal->goal_txt;
                    $each_goal['goal_unit'] = number_format($goal->goal_unit);
                    $percent = ($report['total_value'] / $dividendo) * 100;
                    $each_goal['percent'] = round($percent, 2) .' %';
                    $goals[] = $each_goal;
                    $each_goal = [];
                }

                $report['goals'] = $goals;
            }

            $reports[] = $report;
            $report = [];
        }

        return view('results.index', compact('reports', 'roles', 'role_id'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2(Request $request)
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
    public function show($id) {
        $result = Result::where('id', $id)->with('rol')->get()->first();
        $results = "";

        return view('results.show', compact('result', 'results'));
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
    public function destroy($id) {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        //dd($request->all());
        $roles = Role::all()->sortBy('name')->except(1);
        $results = Result::where('rol_id', $request->uar)->get();
        $reports = [];
        $role_id = $request->uar;

        foreach ($results as $result) {
            $report['id'] = $result->id;
            $report['role'] = $result->rol->name;
            $report['theme_result'] = $result->theme_result;

            foreach ($result->formulas as $formula) {
                $valus = [];

                foreach($formula->variables as $variable){
                    $valus[] = ItemValueReport::where([
                        ['item_rol_id', $variable->itemrol_id],
                        ['item_col_id', $variable->itemstructure_id]
                    ])->sum('valore');
                }

                $report['total_value'] = number_format(array_sum($valus));
                $goals = [];

                foreach ($result->goals as $goal) {
                    $dividendo = floatval($goal->goal_unit);
                    $each_goal['goal_txt'] = $goal->goal_txt;
                    $each_goal['goal_unit'] = number_format($goal->goal_unit);
                    $percent = ($report['total_value'] / $dividendo) * 100;
                    $each_goal['percent'] = round($percent, 2) .' %';
                    $goals[] = $each_goal;
                    $each_goal = [];
                }

                $report['goals'] = $goals;
            }

            $reports[] = $report;
            $report = [];
        }

        return view('results.index', compact('reports', 'roles', 'role_id'));
    }

    public function buildProgress(Request $request) {
        $messages = [
            'date_start.required'             => 'La fecha inicio es obligatoria',
            'date_end.required'               => 'La fecha fin es obligatoria',
            'date_end.after_or_equal'         => 'La fecha fin debe ser una fecha posterior o igual a fecha inicio',
            'date_start.before_or_equal'      => 'La fecha inicio debe ser una fecha anterior o igual a fecha fin',
            'date_start.date'                 => 'La fecha inicio no es una fecha válida',
            'date_end.date'                   => 'La fecha fin no es una fecha válida',
            'date_start.date_format'          => 'La fecha inicio no corresponde al formato :format',
            'date_end.date_format'            => 'La fecha fin no corresponde al formato :format',
        ];
        $validator = Validator::make($request->all(), [
            'date_start' => 'required|date|date_format:Y-m-d|before_or_equal:date_end',
            'date_end' => 'required|date|date_format:Y-m-d|after_or_equal:date_start'
        ], $messages);

        if ($validator->passes()) {
            $result = Result::findOrFail($request->result_id);

            foreach ($result->formulas as $formula) {
                $valus = [];
                $reports = Report::select('id')->where([
                    ['rol_id', $result->rol_id],
                    ['date_start', '>=', $request->date_start],
                    ['date_end', '<=', $request->date_end]
                ])->get()->toArray();

                foreach($formula->variables as $variable){
                    $valus[] = ItemValueReport::where([
                        ['item_rol_id', $variable->itemrol_id],
                        ['item_col_id', $variable->itemstructure_id]
                    ])->whereIn('report_id', $reports)->sum('valore');
                }

                $report['total_value'] = number_format(array_sum($valus));
                $goals = [];

                foreach ($result->goals as $goal) {
                    $dividendo = floatval($goal->goal_unit);
                    $each_goal['goal_txt'] = $goal->goal_txt;
                    $each_goal['goal_unit'] = number_format($goal->goal_unit);
                    $percent = ($report['total_value'] / $dividendo) * 100;
                    $each_goal['percent'] = round($percent, 2) .' %';
                    $goals[] = $each_goal;
                    $each_goal = [];
                }

                $report['goals'] = $goals;
            }

            return response()->json(['result' => $report]);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }
}