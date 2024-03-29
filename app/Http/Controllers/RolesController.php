<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function __construct()
    {
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
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('roles.index', compact('roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request) {
        $messages = [
            'name.unique' => 'El Nombre del Rol ya ha sido registrado',
        ];

        $request->validate([
            'name' => 'unique:roles,name'
        ], $messages);
        //create role
        $role = Role::create(['name' => $request->name]);
         //update permissions
        $role->permissions()->sync($request->get('permissions'));

        return redirect()->route('roles.edit', $role->id)->with('info', 'Rol creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(role $role) {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(role $role) {
        $permissions = Permission::all();
        //dd($role->permissions->toArray());
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRoleRequest $request, role $role) {
        $messages = [
            'name.unique' => 'El Nombre del Rol ya ha sido registrado',
        ];

        $request->validate([
            'name' => 'unique:roles,name,'. $role->id
        ], $messages);
        //update role
        $role->update(['name' => $request->name]);
         //update permissions
        $role->syncPermissions($request->get('permissions'));

        return redirect()->route('roles.edit', $role->id)->with('info', 'Role actualizado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(role $role) {
        $role->delete();

        return redirect()->route('roles.index')->with('info', 'Rol eliminado satisfactoriamente.');
    }
}
