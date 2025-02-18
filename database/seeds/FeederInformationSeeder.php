<?php

use Illuminate\Database\Seeder;

class FeederInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<100; $i++){
            factory(\App\MLO\Feederinformation::class, 1000)->create();
        }
    }
}
