<?php

use Illuminate\Database\Seeder;

class MoneyReceiptHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $heads = [
            ['name' => 'AMENDMENT', 'description' => null],
            ['name' => 'BANK GUARANTEE FEE', 'description' => null],
            ['name' => 'CLEANING FEE', 'description' => null],
            ['name' => 'DETENTION', 'description' => null],
            ['name' => 'DOCUMENTATION', 'description' => null],
            ['name' => 'DOLPHINE CONTAINER', 'description' => null],
            ['name' => 'DSC / DO FEE', 'description' => null],
            ['name' => 'DTHC', 'description' => null],
            ['name' => 'ECRS', 'description' => null],
            ['name' => 'EMC CHARGES', 'description' => null],
            ['name' => 'ISPS', 'description' => null],
            ['name' => 'LIFTON', 'description' => null],
            ['name' => 'MISC. EXP', 'description' => null],
            ['name' => 'NOC FEE', 'description' => null],
            ['name' => 'OTHERS', 'description' => null],
            ['name' => 'PERMISSION', 'description' => null],
            ['name' => 'REPAIRING', 'description' => null],
            ['name' => 'SEAL FEE', 'description' => null],
            ['name' => 'SERVEY FEE', 'description' => null],
            ['name' => 'STATUS CHANGE', 'description' => null],
        ];

        foreach($heads as $head){
            \App\MoneyReceiptHead::create($head);
        }
    }
}
