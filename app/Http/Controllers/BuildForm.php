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

class BuildForm extends Controller {
    function __construct() {
        $this->middleware('auth');
        $this->middleware(['role:Instituto para el Envejecimiento Digno|Coordinación General de Inclusión y Bienestar|Atención Social y Ciudadana|Subsecretaría de Derechos Humanos|Instituto para la Atención a Poblaciones Prioritarias']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rol = auth()->user()->roles()->first();
        $reports = Report::where([
            ['active', true],
            ['rol_id', $rol->id],
        ])->orderBy('created_at', 'desc')->get();
        //dd($reports);

        return view('forms.index', compact('reports', 'rol'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $rol = auth()->user()->roles()->first();
        $items_rol = ItemRol::where('rol_id', $rol->id)->where('parent_id', null)->get();
        $vals = [];

        return view('forms.create', compact('items_rol', 'rol', 'vals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request) {
        //dd($request->all());
        $post = $request->post();
        $report = Report::crete([
            'rol_id' => $post['rol_id'],
            'created_by' => $post['created_by'],
            'date_start' => $post['date_start'],
            'date_end' => $post['date_end'],
            'active' => $post['active'],
        ]);

        foreach ($post as $key => $value) {
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

        return redirect()->route('forma.create')->with('info', 'Reporte creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $report = Report::findOrFail($id);
        $rol = Role::findOrFail($report->rol_id);
        $items_rol = ItemRol::where('rol_id', $report->rol_id)->where('parent_id', null)->get();
        $items_values = ItemValueReport::where('report_id', $report->id)->get();
        $vals = [];

        foreach ($items_values as $itve) {
            $vals[$itve->item_col_id][$itve->item_rol_id] =[
                'value' => $itve->valore,
                'id' => $itve->id
            ];
        }

        return view('forms.show', compact('rol', 'report', 'items_rol', 'vals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $report = Report::findOrFail($id);
        $rol = Role::findOrFail($report->rol_id);
        $items_rol = ItemRol::where('rol_id', $report->rol_id)->where('parent_id', null)->get();
        $items_values = ItemValueReport::where('report_id', $report->id)->get();
        $vals = [];

        foreach ($items_values as $itve) {
            $vals[$itve->item_col_id][$itve->item_rol_id] =[
                'value' => $itve->valore,
                'id' => $itve->id
            ];
        }

        return view('forms.edit', compact('rol', 'report', 'items_rol', 'vals'));
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
        $post = $request->post();
        $report->date_start = $post['date_start'];
        $report->date_end = $post['date_end'];
        $report->created_by = $post['created_by'];
        $report->save();

        foreach ($post as $key => $value) {
            $field = strpos($key, 'f_');

            if($field>-1 and strlen($value)>-1){
                $pices = explode('_', $key);
                $ivr = ItemValueReport::findOrFail($pices[1]);
                $ivr->valore = $value;
                $ivr->save();
            }
        }

        return redirect()->route('forma.edit', $id)->with('info', 'Reporte actualizado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $report = Report::find($id)->delete();
        $itemValueReport = ItemValueReport::where('report_id', $id)->delete();

        return redirect()->route('forma.index')->with('info', 'Reporte eliminado satisfactoriamente.');
    }
}
