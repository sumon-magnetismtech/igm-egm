<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MLO\Feederinformation;
use Faker\Generator as Faker;

$factory->define(Feederinformation::class, function (Faker $faker) {
    return [
        'feederVessel' => $faker->company,
        'voyageNumber' => "Voyage-".$faker->randomNumber(8, true),
        'COCode' => 301,
        'COName' => "Custom House, Chittagong.",
        'departureDate' => $faker->date(),
        'arrivalDate' => $faker->date(),
        'berthingDate' => $faker->date(),
        'rotationNo' => "Rota-".$faker->randomNumber(6, true),
        'careerName' => 301080083,
        'careerAddress' => 'CANDF TOWER, 4TH FLOOR, AGRABAD, CHITTAGONG, BANGLADESH',
        'depPortCode' => 'ADPAS',
        'depPortName' => 'Pas de la Casa',
        'desPortCode' => 'ADORD',
        'desPortName' => 'Ordino',
        'mtCode' => 1,
        'mtType' => 'Sea Transport',
        'transportNationality' => $faker->country,
        'depot' => 'CHITTAGONG PORT',
        'user_id' => 1
    ];
});
