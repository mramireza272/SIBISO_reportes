<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuizRequest;
use \Spatie\Permission\Models\Permission;
use \Spatie\Permission\Models\Role;
use App\Models\ItemRol;
use App\Models\Report;
use App\Models\RolStructureItem;
use App\Models\ItemValueReport;
use Auth;

class CreateFormController extends Controller {
    function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:create_form')->only(['buildCol', 'buildRow']);
        $this->middleware('permission:index_form')->only('index');
        $this->middleware('permission:edit_form')->only(['edit', 'updateInputName', 'updateEditable']);
        $this->middleware('permission:show_form')->only('show');
        $this->middleware('permission:delete_form')->only(['destroyCol', 'destroyRow']);
    }

    public function index() {
        $roles = Role::all()->sortBy('name')->except([1, 3, 5, 7, 9, 11]);

        return view('forms.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	#

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
        $rol = Role::findOrFail($id);
        $items_rol = ItemRol::where('rol_id', $rol->id)->where('parent_id', null)->orderBy('order')->get();

        return view('forms.show', compact('rol', 'items_rol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $rol = Role::findOrFail($id);
        $items_rol = ItemRol::where('rol_id', $rol->id)->where('parent_id', null)->orderBy('order')->get();

        return view('forms.edit', compact('rol', 'items_rol'));
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

    public function buildCol($item_id) {
        $all = RolStructureItem::all();
        $added = RolStructureItem::create([
            'item_rol_id'=> $item_id,
            'order'=> count($all),
            'columns' => ' nueva columna'
        ]);

        return $added;
    }

    public function destroyCol($item_rol_id, $rol_structure_id) {
        RolStructureItem::findOrFail($rol_structure_id)->delete();
        $rolStructureItem = RolStructureItem::where('item_rol_id', $item_rol_id)->orderBy('id', 'DESC')->first();

        if(empty($rolStructureItem)) {
            return $rol_structure_id;
        } else {
            return ($rol_structure_id .'&'. $item_rol_id .'&'. $rolStructureItem->id);
        }
    }

    public function updateInputName(Request $request) {
        if($request->type == 'rol') {
            RolStructureItem::findOrFail($request->id)->update(['columns' => $request->column, 'updated_at' => date('Y-m-d H:i:s')]);
        } elseif ($request->type == 'item') {
            ItemRol::findOrFail($request->id)->update(['item' => $request->column, 'updated_at' => date('Y-m-d H:i:s')]);
        }

        return;
    }

    public function updateEditable(Request $request) {
        ItemRol::findOrFail($request->id)->update(['editable' => $request->checked, 'updated_at' => date('Y-m-d H:i:s')]);

        return;
    }

    public function buildRow($rol_id, $parent_id) {
        $all_rol = ItemRol::where([
            ['rol_id', $rol_id],
            ['parent_id', $parent_id],
        ])->get()->count();
        $added = ItemRol::create([
            'rol_id' => $rol_id,
            'parent_id' => $parent_id,
            'order' => $all_rol,
            'item' => ' nuevo renglón',
            'editable' => false
        ]);

        return $added;
    }

    public function destroyRow($parent_id, $item_id) {
        $item = ItemRol::findOrFail($item_id)->delete();
        $itemRol = ItemRol::where('parent_id', $parent_id)->orderBy('id', 'DESC')->first();

        if(empty($itemRol)) {
            return $item_id;
        } else {
            return ($item_id .'&'. $itemRol->id .'&'. $itemRol->parent_id);
        }
    }
}