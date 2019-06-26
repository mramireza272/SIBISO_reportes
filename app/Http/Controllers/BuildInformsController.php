<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResultRequest;
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
