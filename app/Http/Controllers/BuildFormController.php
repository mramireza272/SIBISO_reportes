<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use \Spatie\Permission\Models\Permission;
use \Spatie\Permission\Models\Role;
use App\Models\ItemRol;
use App\Models\Report;
use App\Models\RolStructureItem;
use App\Models\ItemValueReport;
use Auth;
use Illuminate\Support\Facades\DB;

class BuildFormController extends Controller {
    function __construct() {
        $this->middleware('auth');
        $this->middleware(['permission:create_ined|create_cgib|create_asc|create_sdh|create_iapp'])->only(['create', 'store']);
        $this->middleware(['permission:index_ined|index_cgib|index_asc|index_sdh|index_iapp'])->only('index');
        $this->middleware(['permission:edit_ined|edit_cgib|edit_asc|edit_sdh|edit_iapp'])->only(['edit', 'update']);
        $this->middleware(['permission:show_ined|show_cgib|show_asc|show_sdh|show_iapp'])->only('show');
        $this->middleware(['permission:delete_ined|delete_cgib|delete_asc|delete_sdh|delete_iapp'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rol = auth()->user()->roles()->first();

        if($rol->name == "Atención Social y Ciudadana" || $rol->name == "Atención Social y Ciudadana (Titular)") {
            $role1 = Role::findByName('Atención Social y Ciudadana');
            $role2 = Role::findByName('Atención Social y Ciudadana (Titular)');
            $reports = Report::where('active', true)->whereIn('rol_id', [$role1->id, $role2->id])->orderBy('created_at', 'desc')->get();
        } elseif($rol->name == "Coordinación General de Inclusión y Bienestar" || $rol->name == "Coordinación General de Inclusión y Bienestar (Titular)") {
            $role1 = Role::findByName('Coordinación General de Inclusión y Bienestar');
            $role2 = Role::findByName('Coordinación General de Inclusión y Bienestar (Titular)');
            $reports = Report::where('active', true)->whereIn('rol_id', [$role1->id, $role2->id])->orderBy('created_at', 'desc')->get();
        } elseif($rol->name == "Instituto para el Envejecimiento Digno" || $rol->name == "Instituto para el Envejecimiento Digno (Titular)") {
            $role1 = Role::findByName('Instituto para el Envejecimiento Digno');
            $role2 = Role::findByName('Instituto para el Envejecimiento Digno (Titular)');
            $reports = Report::where('active', true)->whereIn('rol_id', [$role1->id, $role2->id])->orderBy('created_at', 'desc')->get();
        } elseif($rol->name == "Instituto para la Atención a Poblaciones Prioritarias" || $rol->name == "Instituto para la Atención a Poblaciones Prioritarias (Titular)") {
            $role1 = Role::findByName('Instituto para la Atención a Poblaciones Prioritarias');
            $role2 = Role::findByName('Instituto para la Atención a Poblaciones Prioritarias (Titular)');
            $reports = Report::where('active', true)->whereIn('rol_id', [$role1->id, $role2->id])->orderBy('created_at', 'desc')->get();
        } elseif($rol->name == "Subsecretaría de Derechos Humanos" || $rol->name == "Subsecretaría de Derechos Humanos (Titular)") {
            $role1 = Role::findByName('Subsecretaría de Derechos Humanos');
            $role2 = Role::findByName('Subsecretaría de Derechos Humanos (Titular)');
            $reports = Report::where('active', true)->whereIn('rol_id', [$role1->id, $role2->id])->orderBy('created_at', 'desc')->get();
        }

        return view('reports.index', compact('reports', 'rol'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $role = auth()->user()->roles()->first();
        $items_rol = ItemRol::where('rol_id', $role->id)->where('parent_id', null)->get();
        $vals = [];

        return view('reports.create', compact('items_rol', 'role', 'vals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request) {
        //dd($request->all());
        $report = Report::create($request->all());

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

        return redirect()->route('reportes.create')->with('info', 'Registro creado satisfactoriamente.');
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

        return view('reports.show', compact('role', 'report', 'items_rol', 'vals'));
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

        return view('reports.edit', compact('role', 'report', 'items_rol', 'vals'));
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
        $report->created_by = $request->created_by;
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

        return redirect()->route('reportes.edit', $id)->with('info', 'Registro editado satisfactoriamente.');
    }

    public function updateStatus($id) {
        //dd($id);
        Report::findOrFail($id)->update(['status' => false, 'authorized_by' => \Auth::user()->id]);

        return redirect()->route('reportes.index')->with('info', 'Registro autorizado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $report = Report::findOrFail($id)->delete();
        $itemValueReport = ItemValueReport::where('report_id', $id)->delete();

        return redirect()->route('reportes.index')->with('info', 'Registro eliminado satisfactoriamente.');
    }

    private function checkTime($created_at) {
        $two_hours = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($created_at)));
        $now = date("Y-m-d H:i:s");

        if($now <= $two_hours) {
            return true;
        }

        return false;
    }
}