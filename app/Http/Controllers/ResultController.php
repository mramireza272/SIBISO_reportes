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
    $this->middleware('permission:index_form')->only(['index', 'search']);
    $this->middleware('permission:show_form')->only(['show', 'buildProgress']);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    //dd($request->all());
    $roles = Role::all()->sortBy('name')->except(1);
    $results = Result::all()->sortBy('theme_result')->sortBy('rol_id')->groupBy('rol_id');
    $reports = [];
    $role_id = '';

    foreach($results as $results_list) {
      foreach ($results_list as $result) {
        $report = [];
        $report['id'] = $result->id;
        $report['role'] = $result->rol->name;
        $report['theme_result'] = $result->theme_result;

        foreach ($result->formulas as $formula) {
          if($result->goals->count() > 0) {
            $goals = [];

            foreach ($result->goals as $goal) {
              $valus = [];
              $each_goal = [];
              $reports_ids = Report::select('id')->where([
                ['rol_id', $result->rol_id],
                ['date_start', '>=', $goal->date_start],
                ['date_end', '<=', $goal->date_end]
              ])->get()->toArray();

              foreach($formula->variables as $variable){
                $valus[] = ItemValueReport::where([
                  ['item_rol_id', $variable->itemrol_id],
                  ['item_col_id', $variable->itemstructure_id]
                ])->whereIn('report_id', $reports_ids)->sum('valore');
              }

              $total_value = array_sum($valus);
              $each_goal['total_value'] = number_format($total_value);
              $dividendo = floatval($goal->goal_unit);
              $each_goal['goal_txt'] = $goal->goal_txt;
              $each_goal['goal_unit'] = number_format($goal->goal_unit);
              $percent = ($total_value / $dividendo) * 100;
              $each_goal['percent'] = round($percent, 2) .' %';
              $goals[] = $each_goal;
            }

            $report['goals'] = $goals;
          } else {
            $valus = [];

            foreach($formula->variables as $variable){
              $valus[] = ItemValueReport::where([
                ['item_rol_id', $variable->itemrol_id],
                ['item_col_id', $variable->itemstructure_id]
              ])->sum('valore');
            }

            $report['total_value'] = number_format(array_sum($valus));
          }
        }

        $reports[] = $report;
      }
    }

    //dd($reports);

    return view('results.index', compact('reports', 'roles', 'role_id'));
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
  public function destroy($id)
  {
    //
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request) {
    //dd($request->all());
    $roles = Role::all()->sortBy('name')->except(1);
    //$results = Result::where('rol_id', $request->uar)->orderBy('theme_result')->get();
    $results = Result::where('rol_id', $request->uar)->get()->sortBy('theme_result');
    $reports = [];
    $role_id = $request->uar;

    foreach ($results as $result) {
      $report = [];
      $report['id'] = $result->id;
      $report['role'] = $result->rol->name;
      $report['theme_result'] = $result->theme_result;

      foreach ($result->formulas as $formula) {
        if($result->goals->count() > 0) {
          $goals = [];

          foreach ($result->goals as $goal) {
            $valus = [];
            $each_goal = [];
            $reports_ids = Report::select('id')->where([
              ['rol_id', $result->rol_id],
              ['date_start', '>=', $goal->date_start],
              ['date_end', '<=', $goal->date_end]
            ])->get()->toArray();

            foreach($formula->variables as $variable){
              $valus[] = ItemValueReport::where([
                ['item_rol_id', $variable->itemrol_id],
                ['item_col_id', $variable->itemstructure_id]
              ])->whereIn('report_id', $reports_ids)->sum('valore');
            }

            $total_value = array_sum($valus);
            $each_goal['total_value'] = number_format($total_value);
            $dividendo = floatval($goal->goal_unit);
            $each_goal['goal_txt'] = $goal->goal_txt;
            $each_goal['goal_unit'] = number_format($goal->goal_unit);
            $percent = ($total_value / $dividendo) * 100;
            $each_goal['percent'] = round($percent, 2) .' %';
            $goals[] = $each_goal;
          }

          $report['goals'] = $goals;
        } else {
          $valus = [];

          foreach($formula->variables as $variable){
            $valus[] = ItemValueReport::where([
              ['item_rol_id', $variable->itemrol_id],
              ['item_col_id', $variable->itemstructure_id]
            ])->sum('valore');
          }

          $report['total_value'] = number_format(array_sum($valus));
        }
      }

      $reports[] = $report;
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
      $result = Result::with(['goals' => function ($query) use($request) {
        $query->where([
          ['date_start', '<=', $request->date_start],
          ['date_end', '>=', $request->date_start],
        ])->orWhere([
          ['date_start', '<=', $request->date_end],
          ['date_end', '>=', $request->date_end],
        ])->orWhere([
          ['date_start', '>=', $request->date_start],
          ['date_end', '<=', $request->date_end],
        ]);
      }])->findOrFail($request->result_id);

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

        $total_value = array_sum($valus);
        $report['total_value'] = number_format($total_value);
        $goals = [];

        foreach ($result->goals as $goal) {
          $dividendo = floatval($goal->goal_unit);
          $each_goal['goal_txt'] = $goal->goal_txt;
          $each_goal['goal_unit'] = number_format($goal->goal_unit);
          $percent = ($total_value / $dividendo) * 100;
          $each_goal['percent'] = round($percent, 2) .' %';
          $goals[] = $each_goal;
          $each_goal = [];
        }

        $report['goals'] = $goals;
      }

      return response()->json(['result' => $report, 'otro' => $result]);
    }

    return response()->json(['error' => $validator->errors()->all()]);
  }
}