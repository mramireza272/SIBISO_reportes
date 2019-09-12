<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use App\Models\ItemRol;
use App\Models\Report;
use App\Models\ItemValueReport;
use \Spatie\Permission\Models\Role;

class RecordsController extends Controller {
    function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:index_form')->only(['index', 'search']);
        $this->middleware('permission:edit_form')->only(['edit', 'update']);
        $this->middleware('permission:show_form')->only('show');
        $this->middleware('permission:delete_form')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $all_roles = Role::all()->sortBy('name')->except(1);
        $roles = Role::all()->sortBy('name')->except([1, 3, 5, 7, 9, 11]);
        $role_id = '';
        $records = [];

        for($i = 0; $i < count($all_roles); $i = $i + 2) {
            $record = [];
            $record['id'] = $all_roles[$i]->id;
            $record['name'] = $all_roles[$i]->name;
            $record['records'] = Report::whereIn('rol_id', [$all_roles[$i]->id, $all_roles[$i + 1]->id])->orderBy('created_at', 'desc')->get();
            $records[] = $record;
        }

        return view('records.index', compact('records', 'roles', 'role_id'));
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
        $report = Report::findOrFail($id);
        $role = Role::findOrFail($report->rol_id);
        $items_rol = ItemRol::where('rol_id', $report->rol_id)->where('parent_id', null)->get();
        $items_values = ItemValueReport::where('report_id', $report->id)->get();
        $vals = [];

        foreach ($items_values as $itve) {
            $vals[$itve->item_col_id][$itve->item_rol_id] = [
                'value' => $itve->valore,
                'id' => $itve->id
            ];
        }

        return view('records.show', compact('role', 'report', 'items_rol', 'vals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $report = Report::findOrFail($id);
        $role = Role::findOrFail($report->rol_id);
        $items_rol = ItemRol::where('rol_id', $report->rol_id)->where('parent_id', null)->get();
        $items_values = ItemValueReport::where('report_id', $report->id)->get();
        $vals = [];

        #$forvaluesnotadde
        $itemseditable = ItemRol::where('rol_id', $report->rol_id)->get();

        foreach ($itemseditable as $rol) {
            foreach($rol->cols as $colss){
                foreach ($itemseditable as $interrol) {
                    $vals[$colss->id][$interrol->id] = [
                        'value' => 0,
                        'id' => 0
                    ];
                }
            }
        }

        foreach ($items_values as $itve) {
            $vals[$itve->item_col_id][$itve->item_rol_id] = [
                'value' => $itve->valore,
                'id' => $itve->id
            ];
        }

        return view('records.edit', compact('role', 'report', 'items_rol', 'vals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, $id) {
        //dd($request->all());
        $report = Report::findOrFail($id);
        $report->date_start = $request->date_start;
        $report->date_end = $request->date_end;
        $report->observation = $request->observation;
        $report->created_by = auth()->user()->id;
        $report->updated_at = date("Y-m-d H:i:s");
        $report->save();

        foreach ($request->all() as $key => $value) {
            $field = strpos($key, 'f_');

            if($field>-1 and strlen($value)>-1){
                $pices = explode('_', $key);

                $ivr = ItemValueReport::firstOrCreate([
                    'report_id' => $report->id,
                    'item_rol_id' => $pices[3],
                    'item_col_id' => $pices[2]
                ]);
                $ivr->valore = $value;
                $ivr->save();
            }
        }

        return redirect()->route('registros.edit', $id)->with('info', 'Registro editado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //dd($id);
        $report = Report::findOrFail($id)->delete();
        $itemValueReport = ItemValueReport::where('report_id', $id)->delete();

        return redirect()->route('registros.index')->with('info', 'Registro eliminado satisfactoriamente.');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function search(Request $request) {
        $role = Role::findOrFail($request->uar);
        $roles = Role::all()->sortBy('name')->except([1, 3, 5, 7, 9, 11]);
        $role_id = $request->uar;
        $records = [];
        $record = [];
        $record['id'] = $role->id;
        $record['name'] = $role->name;
        $record['records'] = Report::whereIn('rol_id', [$role_id, $role_id + 1])->orderBy('created_at', 'desc')->get();
        $records[] = $record;

        return view('records.index', compact('records', 'roles', 'role_id'));
    }
}