<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['super-admin', 'admin', 'bl-entry', 'do-entry','mlo-admin','mlo-bl-entry','mlo-do-entry', 'ctrack-data-entry', 'ctrack-report-viewer'];
        foreach($roles as $role){
            \Spatie\Permission\Models\Role::create([
               'name'=> $role,
               'guard_name'=> 'web',
            ]);
        }


    }
}
