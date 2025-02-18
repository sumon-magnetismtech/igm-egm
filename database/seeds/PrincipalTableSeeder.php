<?php

use Illuminate\Database\Seeder;

class PrincipalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(\App\Principal::class, 100000)->create();
        $principals = [
            ['name' => 'Blue Water Line'],
            ['name' => 'Dolphine Line'],
            ['name' => 'QC Maritime Ltd.'],
            ['name' => 'Sea Port Lines'],
            ['name' => 'Mass Shipping'],
            ['name' => 'YTL Line'],
            ['name' => 'Sarjak Line'],
            ['name' => 'Ceekay Shipping PTE. Ltd.'],
            ['name' => 'Merlion Holding PTE. Ltd.'],
            ['name' => 'ATI Freight LLC'],
            ['name' => 'Indus Container Line'],
            ['name' => 'Indial Shipping Pvt Ltd.'],
            ['name' => 'Xllent Marine Line Pvt Ltd.'],
            ['name' => 'Fairmacs Multiline Singapore Pte. Ltd.'],
        ];
        foreach ($principals as $index => $principal) {
            \App\Principal::create($principal);
        }
    }
}
