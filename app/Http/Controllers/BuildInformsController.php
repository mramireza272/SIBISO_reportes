<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResultRequest;
use App\Http\Requests\GoalRequest;
use \Spatie\Permission\Models\Role;
use App\Models\Result;
use App\Models\Goal;
use App\Models\ItemValueReport;
use App\Models\FormulaResult;

class BuildInformsController extends Controller {
    function __construct() {
        $this->middleware('auth');
        /*$this->middleware('permission:create_form')->only(['buildCol', 'buildRow']);
        $this->middleware('permission:index_form')->only('index');
        $this->middleware('permission:edit_form')->only(['edit', 'updateInputName', 'updateEditable']);
        $this->middleware('permission:show_form')->only('show');
        $this->middleware('permission:delete_form')->only('destroyCol');*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $results = Result::with('rol')->orderBy('rol_id')->get();

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
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createGoal($id){
        $result = Result::findOrFail($id);

        return view('informs.goal', compact('result'));
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
}
