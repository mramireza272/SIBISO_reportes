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
    public function run() {
        Permission::create(['name' => 'create_ined']);
        Permission::create(['name' => 'delete_ined']);
        Permission::create(['name' => 'edit_ined']);
        Permission::create(['name' => 'index_ined']);
        Permission::create(['name' => 'show_ined']);
        Permission::create(['name' => 'validate_ined']);

        Permission::create(['name' => 'create_cgib']);
        Permission::create(['name' => 'delete_cgib']);
        Permission::create(['name' => 'edit_cgib']);
        Permission::create(['name' => 'index_cgib']);
        Permission::create(['name' => 'show_cgib']);
        Permission::create(['name' => 'validate_cgib']);

        Permission::create(['name' => 'create_asc']);
        Permission::create(['name' => 'delete_asc']);
        Permission::create(['name' => 'edit_asc']);
        Permission::create(['name' => 'index_asc']);
        Permission::create(['name' => 'show_asc']);
        Permission::create(['name' => 'validate_asc']);

        Permission::create(['name' => 'create_sdh']);
        Permission::create(['name' => 'delete_sdh']);
        Permission::create(['name' => 'edit_sdh']);
        Permission::create(['name' => 'index_sdh']);
        Permission::create(['name' => 'show_sdh']);
        Permission::create(['name' => 'validate_sdh']);

        Permission::create(['name' => 'create_iapp']);
        Permission::create(['name' => 'delete_iapp']);
        Permission::create(['name' => 'edit_iapp']);
        Permission::create(['name' => 'index_iapp']);
        Permission::create(['name' => 'show_iapp']);
        Permission::create(['name' => 'validate_iapp']);

        $role2 = Role::create(['name' => 'Instituto para el Envejecimiento Digno']);
        $role2->givePermissionTo('create_ined');
        $role2->givePermissionTo('delete_ined');
        $role2->givePermissionTo('edit_ined');
        $role2->givePermissionTo('index_ined');
        $role2->givePermissionTo('show_ined');
        $role2->givePermissionTo('index_results');
        $role2->givePermissionTo('show_results');

        $role2_1 = Role::create(['name' => 'Instituto para el Envejecimiento Digno (Titular)']);
        $role2_1->givePermissionTo('create_ined');
        $role2_1->givePermissionTo('delete_ined');
        $role2_1->givePermissionTo('edit_ined');
        $role2_1->givePermissionTo('index_ined');
        $role2_1->givePermissionTo('show_ined');
        $role2_1->givePermissionTo('validate_ined');
        $role2_1->givePermissionTo('index_results');
        $role2_1->givePermissionTo('show_results');

        $role3 = Role::create(['name' => 'Coordinación General de Inclusión y Bienestar']);
        $role3->givePermissionTo('create_cgib');
        $role3->givePermissionTo('delete_cgib');
        $role3->givePermissionTo('edit_cgib');
        $role3->givePermissionTo('index_cgib');
        $role3->givePermissionTo('show_cgib');
        $role3->givePermissionTo('index_results');
        $role3->givePermissionTo('show_results');

        $role3_1 = Role::create(['name' => 'Coordinación General de Inclusión y Bienestar (Titular)']);
        $role3_1->givePermissionTo('create_cgib');
        $role3_1->givePermissionTo('delete_cgib');
        $role3_1->givePermissionTo('edit_cgib');
        $role3_1->givePermissionTo('index_cgib');
        $role3_1->givePermissionTo('show_cgib');
        $role3_1->givePermissionTo('validate_cgib');
        $role3_1->givePermissionTo('index_results');
        $role3_1->givePermissionTo('show_results');

        $role4 = Role::create(['name' => 'Atención Social y Ciudadana']);
        $role4->givePermissionTo('create_asc');
        $role4->givePermissionTo('delete_asc');
        $role4->givePermissionTo('edit_asc');
        $role4->givePermissionTo('index_asc');
        $role4->givePermissionTo('show_asc');
        $role4->givePermissionTo('index_results');
        $role4->givePermissionTo('show_results');

        $role4_1 = Role::create(['name' => 'Atención Social y Ciudadana (Titular)']);
        $role4_1->givePermissionTo('create_asc');
        $role4_1->givePermissionTo('delete_asc');
        $role4_1->givePermissionTo('edit_asc');
        $role4_1->givePermissionTo('index_asc');
        $role4_1->givePermissionTo('show_asc');
        $role4_1->givePermissionTo('validate_asc');
        $role4_1->givePermissionTo('index_results');
        $role4_1->givePermissionTo('show_results');

        $role5 = Role::create(['name' => 'Subsecretaría de Derechos Humanos']);
        $role5->givePermissionTo('create_sdh');
        $role5->givePermissionTo('delete_sdh');
        $role5->givePermissionTo('edit_sdh');
        $role5->givePermissionTo('index_sdh');
        $role5->givePermissionTo('show_sdh');
        $role5->givePermissionTo('index_results');
        $role5->givePermissionTo('show_results');

        $role5_1 = Role::create(['name' => 'Subsecretaría de Derechos Humanos (Titular)']);
        $role5_1->givePermissionTo('create_sdh');
        $role5_1->givePermissionTo('delete_sdh');
        $role5_1->givePermissionTo('edit_sdh');
        $role5_1->givePermissionTo('index_sdh');
        $role5_1->givePermissionTo('show_sdh');
        $role5_1->givePermissionTo('validate_sdh');
        $role5_1->givePermissionTo('index_results');
        $role5_1->givePermissionTo('show_results');

        $role6 = Role::create(['name' => 'Instituto para la Atención a Poblaciones Prioritarias']);
        $role6->givePermissionTo('create_iapp');
        $role6->givePermissionTo('delete_iapp');
        $role6->givePermissionTo('edit_iapp');
        $role6->givePermissionTo('index_iapp');
        $role6->givePermissionTo('show_iapp');
        $role6->givePermissionTo('index_results');
        $role6->givePermissionTo('show_results');

        $role6_1 = Role::create(['name' => 'Instituto para la Atención a Poblaciones Prioritarias (Titular)']);
        $role6_1->givePermissionTo('create_iapp');
        $role6_1->givePermissionTo('delete_iapp');
        $role6_1->givePermissionTo('edit_iapp');
        $role6_1->givePermissionTo('index_iapp');
        $role6_1->givePermissionTo('show_iapp');
        $role6_1->givePermissionTo('validate_iapp');
        $role6_1->givePermissionTo('index_results');
        $role6_1->givePermissionTo('show_results');

        $user2 = User::create([
                'name' => $role2->name,
                'email' => 'rol2@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1
            ]);
        $user2->assignRole($role2->name);

        $user2_1 = User::create([
                'name' => $role2_1->name,
                'email' => 'titular2@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1
            ]);
        $user2_1->assignRole($role2_1->name);

        $user3 = User::create([
                'name' => $role3->name,
                'email' => 'rol3@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user3->assignRole($role3->name);

        $user3_1 = User::create([
                'name' => $role3_1->name,
                'email' => 'titular3@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user3_1->assignRole($role3_1->name);

        $user4 = User::create([
                'name' => $role4->name,
                'email' => 'rol4@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user4->assignRole($role4->name);

        $user4_1 = User::create([
                'name' => $role4_1->name,
                'email' => 'titular4@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user4_1->assignRole($role4_1->name);

        $user5 = User::create([
                'name' => $role5->name,
                'email' => 'rol5@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user5->assignRole($role5->name);

        $user5_1 = User::create([
                'name' => $role5_1->name,
                'email' => 'titular5@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user5_1->assignRole($role5_1->name);

        $user6 = User::create([
                'name' => $role6->name,
                'email' => 'rol6@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user6->assignRole($role6->name);

        $user6_1 = User::create([
                'name' => $role6_1->name,
                'email' => 'titular6@rol.rol',
                'password' => '1234',
                'active' => 1,
                'confirmed' => 1,
            ]);
        $user6_1->assignRole($role6_1->name);
    }
}