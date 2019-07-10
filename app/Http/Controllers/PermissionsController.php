<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    private $event;
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:create_roles')->only(['create', 'store']);
        $this->middleware('permission:index_roles')->only('index');
        $this->middleware('permission:edit_roles')->only(['edit', 'update']);
        $this->middleware('permission:show_roles')->only('show');
        $this->middleware('permission:delete_roles')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $permissions = Permission::all()->sortBy('id');

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permissions = Permission::orderBy('created_at', 'desc')->get();

        return view('permissions.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request) {
        $messages = [
            'name.unique' => 'El Nombre del Permiso ya ha sido registrado',
        ];

        $request->validate([
            'name' => 'unique:permissions,name'
        ], $messages);
        //create role
        $permission = Permission::create($request->all());

        return redirect()->route('permisos.edit', $permission->id)->with('info', 'Permiso creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $permission = Permission::findOrFail($id);

        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $permission = Permission::where('id', $id)->first();
        $permissions = Permission::orderBy('created_at', 'desc')->get();

        //dd($role->permissions->toArray());
        return view('permissions.edit', compact('permission', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id) {
        $messages = [
            'name.unique' => 'El Nombre del Permiso ya ha sido registrado',
        ];

        $request->validate([
            'name' => 'unique:permissions,name,'. $id
        ], $messages);

        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name, 'description' => $request->description]);

        return redirect()->route('permisos.edit', $permission->id)->with('info', 'Permiso actualizado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $permission = Permission::where('id', $id)->delete();

        return redirect()->route('permisos.index')->with('info', 'Permiso eliminado satisfactoriamente.');
    }
}