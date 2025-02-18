<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            //Role Management
            'permission-create','permission-edit','permission-view','permission-delete',
            'role-create','role-edit','role-view','role-delete',
            'user-create','user-edit','user-view','user-delete',

            //Data Encoding
            'officename-create','officename-edit','officename-view','officename-delete',
            'vatreg-create','vatreg-edit','vatreg-view','vatreg-delete',
            'package-create','package-edit','package-view','package-delete',
            'location-create','location-edit','location-view','location-delete',
            'containertype-create','containertype-edit','containertype-view','containertype-delete',
            'commodity-create','commodity-edit','commodity-view','commodity-delete',
            'offdock-create','offdock-edit','offdock-view','offdock-delete',
            'cnfagent-create','cnfagent-edit','cnfagent-view','cnfagent-delete',
            'principal-create','principal-edit','principal-view','principal-delete',
            'moneyreceipthead-create','moneyreceipthead-edit','moneyreceipthead-view','moneyreceipthead-delete',

            //Forwarding Core Models
            'masterbl-create','masterbl-edit','masterbl-view','masterbl-delete',
            'housebl-create','housebl-edit','housebl-view','housebl-delete',
            'moneyreceipt-create','moneyreceipt-edit','moneyreceipt-view','moneyreceipt-delete',
            'deliveryorder-create','deliveryorder-edit','deliveryorder-view','deliveryorder-delete',

            //MLO Core Models
            'mlo-feederinformation-create','mlo-feederinformation-edit','mlo-feederinformation-view','mlo-feederinformation-delete',
            'mlo-mloblinformation-create','mlo-mloblinformation-edit','mlo-mloblinformation-view','mlo-mloblinformation-delete',
            'mlo-moneyreceipt-create','mlo-moneyreceipt-edit','mlo-moneyreceipt-view','mlo-moneyreceipt-delete',
            'mlo-deliveryorder-create','mlo-deliveryorder-edit','mlo-deliveryorder-view','mlo-deliveryorder-delete',

            /*
            'container-create','container-edit','container-view','container-delete',
            'containerlocation-create','containerlocation-edit','containerlocation-view','containerlocation-delete',
            'country-create','country-edit','country-view','country-delete',
            'description-create','description-edit','description-view','description-delete',
            'exportcontainer-create','exportcontainer-edit','exportcontainer-view','exportcontainer-delete',
            'exporterinfo-create','exporterinfo-edit','exporterinfo-view','exporterinfo-delete',
            'forwardingrecords-create','Forwardingrecords-edit','Forwardingrecords-view','Forwardingrecords-delete',
            'moneyreceiptdetail-create','moneyreceiptdetail-edit','moneyreceiptdetail-view','moneyreceiptdetail-delete',
            */

        ];
//        $userRole = \Spatie\Permission\Models\Role::where('name', 'super-admin')->firstOrFail();
        foreach($permissions as $permission){
            \Spatie\Permission\Models\Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
//            $userRole->givePermissionTo($permission);
        }
    }
}
