<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	Permission::create(['name' => 'create_user']);
    	Permission::create(['name' => 'delete_user']);
    	Permission::create(['name' => 'edit_user']);
    	Permission::create(['name' => 'index_user']);

        Permission::create(['name' => 'create_roles']);
        Permission::create(['name' => 'delete_roles']);
        Permission::create(['name' => 'edit_roles']);
        Permission::create(['name' => 'index_roles']);
        Permission::create(['name' => 'show_roles']);

        $role = Role::create(['name' => 'Administrador']);      

        $role->givePermissionTo('create_user');
        $role->givePermissionTo('delete_user');
        $role->givePermissionTo('edit_user');
        $role->givePermissionTo('index_user');

        $role->givePermissionTo('create_roles');
        $role->givePermissionTo('delete_roles');
        $role->givePermissionTo('edit_roles');
        $role->givePermissionTo('index_roles');
        $role->givePermissionTo('show_roles');

        $user =  User::findOrFail(1);
        $user->assignRole('Administrador');

    }
}
