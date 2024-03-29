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
    $this->middleware('permission:index_results')->only('index');
    $this->middleware('permission:search_results')->only('search');
    $this->middleware('permission:show_results')->only(['show', 'buildProgress']);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $rol = auth()->user()->roles()->first();
    $role_id = '';
    $roles = '';
    $date_start = '';
    $date_end = '';
    $reports = [];
    $results = [];

    if($rol->name == "Administrador") {
      $roles = Role::all()->sortBy('name')->except([1, 3, 5, 7, 9, 11]);
      $results = Result::select('results.*', 'r.name')->join('roles AS r', 'r.id', '=', 'results.rol_id')->orderBy('r.name')->orderBy('theme_result')->get();
    } elseif($rol->name == "Atención Social y Ciudadana" || $rol->name == "Atención Social y Ciudadana (Titular)") {
      $role1 = Role::findByName('Atención Social y Ciudadana');
      $role2 = Role::findByName('Atención Social y Ciudadana (Titular)');
      $results = Result::whereIn('rol_id', [$role1->id, $role2->id])->orderBy('theme_result')->get();
    } elseif($rol->name == "Coordinación General de Inclusión y Bienestar" || $rol->name == "Coordinación General de Inclusión y Bienestar (Titular)") {
      $role1 = Role::findByName('Coordinación General de Inclusión y Bienestar');
      $role2 = Role::findByName('Coordinación General de Inclusión y Bienestar (Titular)');
      $results = Result::whereIn('rol_id', [$role1->id, $role2->id])->orderBy('theme_result')->get();
    } elseif($rol->name == "Instituto para el Envejecimiento Digno" || $rol->name == "Instituto para el Envejecimiento Digno (Titular)") {
      $role1 = Role::findByName('Instituto para el Envejecimiento Digno');
      $role2 = Role::findByName('Instituto para el Envejecimiento Digno (Titular)');
      $results = Result::whereIn('rol_id', [$role1->id, $role2->id])->orderBy('theme_result')->get();
    } elseif($rol->name == "Instituto para la Atención a Poblaciones Prioritarias" || $rol->name == "Instituto para la Atención a Poblaciones Prioritarias (Titular)") {
      $role1 = Role::findByName('Instituto para la Atención a Poblaciones Prioritarias');
      $role2 = Role::findByName('Instituto para la Atención a Poblaciones Prioritarias (Titular)');
      $results = Result::whereIn('rol_id', [$role1->id, $role2->id])->orderBy('theme_result')->get();
    } elseif($rol->name == "Subsecretaría de Derechos Humanos" || $rol->name == "Subsecretaría de Derechos Humanos (Titular)") {
      $role1 = Role::findByName('Subsecretaría de Derechos Humanos');
      $role2 = Role::findByName('Subsecretaría de Derechos Humanos (Titular)');
      $results = Result::whereIn('rol_id', [$role1->id, $role2->id])->orderBy('theme_result')->get();
    }

    foreach ($results as $result) {
      $report = [];
      $report['id'] = $result->id;
      $report['role'] = $result->rol->name;
      $report['theme_result'] = $result->theme_result;
      $report['description'] = $result->description;

      foreach ($result->formulas as $formula) {
        if($result->goals->count() > 0) {
          $goals = [];

          foreach ($result->goals as $goal) {
            $valus = [];
            $each_goal = [];
            $reports_ids = Report::select('id')->where([
              ['rol_id', $result->rol_id],
              ['date_start', '<=', $goal->date_start],
              ['date_end', '>=', $goal->date_start]
            ])->orWhere([
              ['rol_id', $result->rol_id],
              ['date_start', '<=', $goal->date_end],
              ['date_end', '>=', $goal->date_end]
            ])->orWhere([
              ['rol_id', $result->rol_id],
              ['date_start', '>=', $goal->date_start],
              ['date_end', '<=', $goal->date_end]
            ])->get()->toArray();

            foreach($formula->variables as $variable) {
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
            $each_goal['percent'] = number_format(round($percent, 2)) .' %';
            $goals[] = $each_goal;
          }

          $report['goals'] = $goals;
        } else {
          $valus = [];

          foreach($formula->variables as $variable) {
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

    return view('results.index', compact('reports', 'roles', 'role_id', 'date_start', 'date_end'));
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
    //$result = Result::where('id', $id)->with('rol')->get()->first();
    $result = Result::findOrFail($id);
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
    if(($request->date_start != null) || ($request->date_end != null)) {
      $messages = [
        'date_start.required'             => 'La fecha inicio es obligatoria',
        'date_end.required'               => 'La fecha fin es obligatoria',
        'date_end.after_or_equal'         => 'La fecha fin debe ser una fecha posterior o igual a fecha inicio',
        'date_start.before_or_equal'      => 'La fecha inicio debe ser una fecha anterior o igual a fecha fin',
        'date_start.date'                 => 'La fecha inicio no es una fecha válida',
        'date_end.date'                   => 'La fecha fin no es una fecha válida',
        'date_start.date_format'          => 'La fecha inicio no corresponde al formato AAAA-MM-DD',
        'date_end.date_format'            => 'La fecha fin no corresponde al formato AAAA-MM-DD',
        'uar.required'                    => 'La Unidad Administrativa Responsable es obligatoria',
      ];
      $request->validate([
        'date_start' => 'required|date|date_format:Y-m-d|before_or_equal:date_end',
        'date_end'   => 'required|date|date_format:Y-m-d|after_or_equal:date_start',
        'uar'        => 'required',
      ], $messages);
      $results = Result::with(['goals' => function ($query) use($request) {
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
      }])->where('rol_id', $request->uar)->get()->sortBy('theme_result');
    } else {
      $messages = [
        'uar.required'                    => 'La Unidad Administrativa Responsable es obligatoria',
      ];
      $request->validate([
        'uar'        => 'required',
      ], $messages);
      $results = Result::where('rol_id', $request->uar)->get()->sortBy('theme_result');
    }

    $roles = Role::all()->sortBy('name')->except([1, 3, 5, 7, 9, 11]);
    $reports = [];
    $role_id = $request->uar;
    $date_start = $request->date_start;
    $date_end = $request->date_end;

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
              ['date_start', '<=', $goal->date_start],
              ['date_end', '>=', $goal->date_start]
            ])->orWhere([
              ['rol_id', $result->rol_id],
              ['date_start', '<=', $goal->date_end],
              ['date_end', '>=', $goal->date_end]
            ])->orWhere([
              ['rol_id', $result->rol_id],
              ['date_start', '>=', $goal->date_start],
              ['date_end', '<=', $goal->date_end]
            ])->get()->toArray();

            foreach($formula->variables as $variable) {
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
            $each_goal['percent'] = number_format(round($percent, 2)) .' %';
            $goals[] = $each_goal;
          }

          $report['goals'] = $goals;
        } else {
          $valus = [];

          foreach($formula->variables as $variable) {
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

    return view('results.index', compact('reports', 'roles', 'role_id', 'date_start', 'date_end'));
  }

  public function buildProgress(Request $request) {
    $messages = [
      'date_start.required'             => 'La fecha inicio es obligatoria',
      'date_end.required'               => 'La fecha fin es obligatoria',
      'date_end.after_or_equal'         => 'La fecha fin debe ser una fecha posterior o igual a fecha inicio',
      'date_start.before_or_equal'      => 'La fecha inicio debe ser una fecha anterior o igual a fecha fin',
      'date_start.date'                 => 'La fecha inicio no es una fecha válida',
      'date_end.date'                   => 'La fecha fin no es una fecha válida',
      'date_start.date_format'          => 'La fecha inicio no corresponde al formato AAAA-MM-DD',
      'date_end.date_format'            => 'La fecha fin no corresponde al formato AAAA-MM-DD',
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

        foreach($formula->variables as $variable) {
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

      return response()->json(['result' => $report]);
    }

    return response()->json(['error' => $validator->errors()->all()]);
  }
}