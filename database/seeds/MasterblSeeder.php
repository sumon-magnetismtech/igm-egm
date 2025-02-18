<?php

use Illuminate\Database\Seeder;
use App\Masterbl;
class MasterblSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<100; $i++){
            factory(Masterbl::class, 10000)->create();
        }
    }
}
