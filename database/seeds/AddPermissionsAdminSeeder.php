<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class AddPermissionsAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Permission::create(['name' => 'create_form']);
        Permission::create(['name' => 'delete_form']);
        Permission::create(['name' => 'edit_form']);
        Permission::create(['name' => 'index_form']);
        Permission::create(['name' => 'show_form']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('create_form');
        $role->givePermissionTo('delete_form');
        $role->givePermissionTo('edit_form');
        $role->givePermissionTo('index_form');
        $role->givePermissionTo('show_form');
    }
}
