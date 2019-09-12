<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use DB;

class UserController extends Controller
{
    function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:create_user')->only(['create', 'store']);
        $this->middleware('permission:index_user')->only(['index', 'search']);
        $this->middleware('permission:edit_user')->only(['edit', 'update']);
        $this->middleware('permission:delete_user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //oculto el usuario de CGPI
        $users = User::where([
            ['active', true],
            ['email', '<>', 'admin@territorial']
        ])->orderBy('created_at', 'desc')->get();
        $search = "";

        return view('Users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = array();

        if(auth()->user()->hasRole(['Administrador'])){
            $roles = $this->getRoles();
        }

        return view('Users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request) {
        $messages = [
            'email.unique' => 'El Correo Personal ya ha sido registrado',
        ];

        $request->validate([
            'email' => 'unique:users,email'
        ], $messages);

        $input = $request->all();
        $input['created_by'] = auth()->user()->id;
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.create')->with('info', 'Usuario(a) creado(a) satisfactoriamente');
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
    public function edit($id) {
        $user = User::findOrFail($id);
        $roles = $this->getRoles();
        $btnText = 'Actualizar';

        return view('Users.edit', compact('user', 'roles', 'btnText'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id) {
        $messages = [
            'email.unique' => 'El Correo Personal ya ha sido registrado',
        ];

        $request->validate([
            'email' => 'unique:users,email,'. $id
        ], $messages);

        $user = User::findOrFail($id);
        $input = $request->all();
        $input['created_by'] = auth()->user()->id;
        $input['updated_at'] = date('Y-m-d H:i:s');
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.edit', $id)->with('info', 'Usuario(a) actualizado(a) satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::findOrFail($id)->update(['created_by' => auth()->user()->id, 'updated_at' => date('Y-m-d H:i:s'), 'active' => false]);

        return redirect()->route('usuarios.index')->with('info', 'Usuario(a) deshabilitado(a) satisfactoriamente.');
    }

    /**
     * Search resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $users = User::where([
            ['active', true],
            ['email', '<>', 'admin@territorial'],
        ])->where(function ($query) use ($request) {
            $query->where('name', 'ilike', '%'. $request->search .'%')->orWhere('email', 'ilike', '%'. $request->search .'%');
        })->orderBy('name', 'ASC')->get();
        //$userscount = $users->count();
        $search = $request->search;

        return view('Users.index', compact('users', 'search'));
    }

    private function getRoles() {
        $roles = Role::orderBy('name')->pluck('name', 'name');

        return $roles;
    }
}