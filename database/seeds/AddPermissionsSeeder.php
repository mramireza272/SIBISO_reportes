<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class AddPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create_ined']);
        Permission::create(['name' => 'delete_ined']);
        Permission::create(['name' => 'edit_ined']);
        Permission::create(['name' => 'index_ined']);

        Permission::create(['name' => 'create_cgib']);
        Permission::create(['name' => 'delete_cgib']);
        Permission::create(['name' => 'edit_cgib']);
        Permission::create(['name' => 'index_cgib']);

        Permission::create(['name' => 'create_asc']);
        Permission::create(['name' => 'delete_asc']);
        Permission::create(['name' => 'edit_asc']);
        Permission::create(['name' => 'index_asc']);

        Permission::create(['name' => 'create_sdh']);
        Permission::create(['name' => 'delete_sdh']);
        Permission::create(['name' => 'edit_sdh']);
        Permission::create(['name' => 'index_sdh']);

        Permission::create(['name' => 'create_iapp']);
        Permission::create(['name' => 'delete_iapp']);
        Permission::create(['name' => 'edit_iapp']);
        Permission::create(['name' => 'index_iapp']);

        $role = Role::findByName('Administrador');

        $role->givePermissionTo('create_ined');
        $role->givePermissionTo('delete_ined');
        $role->givePermissionTo('edit_ined');
        $role->givePermissionTo('index_ined');

        $role->givePermissionTo('create_cgib');
        $role->givePermissionTo('delete_cgib');
        $role->givePermissionTo('edit_cgib');
        $role->givePermissionTo('index_cgib');

        $role->givePermissionTo('create_asc');
        $role->givePermissionTo('delete_asc');
        $role->givePermissionTo('edit_asc');
        $role->givePermissionTo('index_asc');

        $role->givePermissionTo('create_sdh');
        $role->givePermissionTo('delete_sdh');
        $role->givePermissionTo('edit_sdh');
        $role->givePermissionTo('index_sdh');

        $role->givePermissionTo('create_iapp');
        $role->givePermissionTo('delete_iapp');
        $role->givePermissionTo('edit_iapp');
        $role->givePermissionTo('index_iapp');

        $user = User::findOrFail(1);
        $user->syncRoles('Administrador');

        $role2 = Role::create(['name' => 'Instituto para el Envejecimiento Digno']);

        $role2->givePermissionTo('create_ined');
        $role2->givePermissionTo('delete_ined');
        $role2->givePermissionTo('edit_ined');
        $role2->givePermissionTo('index_ined');

        $role3 = Role::create(['name' => 'Coordinación General de Inclusión y Bienestar']);

        $role3->givePermissionTo('create_cgib');
        $role3->givePermissionTo('delete_cgib');
        $role3->givePermissionTo('edit_cgib');
        $role3->givePermissionTo('index_cgib');

        $role4 = Role::create(['name' => 'Atención Social y Ciudadana']);

        $role4->givePermissionTo('create_asc');
        $role4->givePermissionTo('delete_asc');
        $role4->givePermissionTo('edit_asc');
        $role4->givePermissionTo('index_asc');

        $role5 = Role::create(['name' => 'Subsecretaría de Derechos Humanos']);

        $role5->givePermissionTo('create_sdh');
        $role5->givePermissionTo('delete_sdh');
        $role5->givePermissionTo('edit_sdh');
        $role5->givePermissionTo('index_sdh');

        $role6 = Role::create(['name' => 'Instituto para la Atención a Poblaciones Prioritarias']);

        $role6->givePermissionTo('create_iapp');
        $role6->givePermissionTo('delete_iapp');
        $role6->givePermissionTo('edit_iapp');
        $role6->givePermissionTo('index_iapp');


        $user = User::create([
                'name' => $role2->name,
                'email' => 'rol2@rol.rol',
                'password' => 'roler',
                'active' => 1,
                'confirmed' => 1
            ]);
        

        
        $user->assignRole($role2->name);



        $user = User::create([
                'name' => $role3->name,
                'email' => 'rol3@rol.rol',
                'password' => 'roler',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user->assignRole($role3->name);
        $user = User::create([
                'name' => $role4->name,
                'email' => 'rol4@rol.rol',
                'password' => 'roler',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user->assignRole($role4->name);
        $user = User::create([
                'name' => $role5->name,
                'email' => 'rol5@rol.rol',
                'password' => 'roler',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user->assignRole($role5->name);
        
        $user = User::create([
                'name' => $role6->name,
                'email' => 'rol6@rol.rol',
                'password' => 'roler',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user->assignRole($role6->name);


    }

}
