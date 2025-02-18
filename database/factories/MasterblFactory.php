<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Masterbl;
use Faker\Generator as Faker;

$factory->define(Masterbl::class, function (Faker $faker) {
    return [
    'noc' => $faker->randomElement([0, 1]),
    'cofficecode' => 301,
    'cofficename' => "Custom House, Chittagong",
    'mblno' => $faker->randomNumber(8, true),
    'blnaturecode' => 23,
    'blnaturetype' => 'Import',
    'bltypecode' => 'HSB',
    'bltypename' => 'House Sea Bill',
    'fvessel' => $faker->text(10),
    'voyage' => $faker->randomNumber(4, true),
    'rotno' => $faker->randomNumber(6, true),
    'principal' => "Principal_".$faker->text(6),
    'departure' => $faker->date('Y-m-d'),
    'arrival' => $faker->date('Y-m-d'),
    'berthing' => $faker->date('Y-m-d'),
    'freetime' => $faker->numberBetween(0, 20),
    'pocode' => $faker->randomNumber(5, true),
    'poname' => $faker->text(10),
    'pucode' => "BDCGP",
    'puname' => "Chittagong",
    'carrier' => "301080083",
    'carrieraddress' => "CANDF TOWER, 4TH FLOOR, AGRABAD, CHITTAGONG, BANGLADESH",
    'depot' => "CHITTAGONG PORT",
    'mv' => $faker->text(15),
    'mlocode' => $faker->randomNumber(5, true),
    'mloname' => $faker->company,
    'mloaddress' => $faker->address,
    'mloLineNo' => $faker->numberBetween(0,100000),
    'mloCommodity' => "Fabrics",
    'contMode' => $faker->randomElement(['LCL', 'FCL', 'PRT', "ETY"]),
    ];

});
