<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
    	$this->call(UsersSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(AddPermissionsAdminSeeder::class);
        $this->call(AddPermissionsSeeder::class);
        $this->call(ItemRolSeeder::class);
        $this->call(ItemRolTitularSeeder::class);
        $this->call(ItemRolForm1::class);
        $this->call(ItemRolForm1Titular::class);
        $this->call(ItemRolForm2::class);
        $this->call(ItemRolForm2Titular::class);
        $this->call(ItemRolForm3::class);
        $this->call(ItemRolForm3Titular::class);
        $this->call(ItemRolForm4::class);
        $this->call(ItemRolForm4Titular::class);
    }
}