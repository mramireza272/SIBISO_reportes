<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@sibiso.cdmx.gob.mx',
            'password' => bcrypt('admin'),
            'active' => 1,
            'confirmed' => 1,
        ]);
    }
}
