<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResultRequest;
use App\Http\Requests\GoalRequest;
use App\Http\Requests\VariableRequest;
use \Spatie\Permission\Models\Role;
use App\Models\Result;
use App\Models\Goal;
use App\Models\ItemValueReport;
use App\Models\ItemRol;
use App\Models\FormulaResult;
use App\Models\VariableFormula;
use Validator;

class BuildInformsController extends Controller {
    function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:create_form')->only(['create', 'store', 'createGoal', 'storeGoal', 'createVariable', 'storeVariable']);
        $this->middleware('permission:index_form')->only('index');
        $this->middleware('permission:edit_form')->only(['edit', 'update', 'updateGoal']);
        $this->middleware('permission:show_form')->only('show');
        $this->middleware('permission:delete_form')->only('destroyGoal');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $results = Result::select('results.*', 'r.name')->join('roles AS r', 'r.id', '=', 'results.rol_id')->orderBy('r.name')->orderBy('theme_result')->groupBy(['results.id', 'r.name', 'results.rol_id'])->get();
        //dd($results);
        //$results = Result::all()->sortBy('theme_result')->groupBy('rol_id');

        return view('informs.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $roles = Role::all()->sortBy('name')->except(1);

        return view('informs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResultRequest $request) {
        //dd($request->all());
        Result::create($request->all());

        return redirect()->route('informes.create')->with('info', 'Informe creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $result = Result::where('id', $id)->with(['goals', 'rol'])->orderBy('created_at')->get()->first();
        //dd($result);

        return view('informs.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $result = Result::findOrFail($id);
        $roles = Role::all()->sortBy('name')->except(1);

        return view('informs.edit', compact('result', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResultRequest $request, $id) {
        //dd($request->all());
        $result = Result::findOrFail($id)->update($request->all());

        return redirect()->route('informes.edit', $id)->with('info', 'Informe actualizado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createGoal($id){
        $result = Result::findOrFail($id);
        $goals = Goal::where('result_id', $result->id)->orderBy('id')->get();

        return view('informs.goal', compact('result', 'goals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGoal(GoalRequest $request) {
        //dd($request->all());
        Goal::create($request->all());

        return redirect()->route('informes.creategoal', $request->result_id)->with('info', 'Meta creada satisfactoriamente.');
    }

    public function updateGoal(Request $request) {
        if($request->filled('goal_txt')) {
            Goal::findOrFail($request->id)->update(['goal_txt' => $request->goal_txt]);
        } elseif($request->filled('goal_unit')) {
            Goal::findOrFail($request->id)->update(['goal_unit' => $request->goal_unit]);
        } elseif($request->filled('type')) {
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
                if($request->type == "start") {
                    Goal::findOrFail($request->id)->update(['date_start' => $request->date_start]);
                } elseif($request->type == "end") {
                    Goal::findOrFail($request->id)->update(['date_end' => $request->date_end]);
                }
            }

            return response()->json(['error' => $validator->errors()->all()]);
        }

        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyGoal(Request $request){
        //dd($request->all());
        Goal::findOrFail($request->id)->delete();

        return redirect()->route('informes.creategoal', $request->result_id)->with('info', 'Meta eliminada satisfactoriamente.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createVariable($id){
        $result = Result::findOrFail($id);
        $formulaResult = FormulaResult::firstOrCreate([
            'result_id' => $result->id,
            'formula' => 'sum'
        ]);
        $rows = ItemRol::where([
            ['rol_id', $result->rol_id],
            ['parent_id', null]
        ])->get();
        $actives = [];

        foreach($formulaResult->variables as $fova){
            $actives[$fova->itemrol_id][$fova->itemstructure_id] = 'checked';
        }

        $variable = VariableFormula::where('formula_id', $formulaResult->id)->count();
        $variable = ($variable > 0) ? 'Editar Variable' : 'Nueva Variable';
        $btnText = ($variable == 'Editar Variable') ? 'Actualizar' : 'Guardar';

        return view('informs.variable', compact('result', 'formulaResult', 'rows', 'actives', 'variable', 'btnText'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeVariable(VariableRequest $request) {
        //dd($request->all());
        VariableFormula::where('formula_id', $request->formula_id)->delete();

        foreach($request->check as $variable) {
            $pices = explode('_', $variable);
            VariableFormula::create([
                'formula_id' => $request->formula_id,
                'itemrol_id' => $pices[0],
                'itemstructure_id' => $pices[1]
            ]);
        }

        return redirect()->route('informes.createvariable', $request->result_id)->with('info', 'Variable creada satisfactoriamente.');
    }
}