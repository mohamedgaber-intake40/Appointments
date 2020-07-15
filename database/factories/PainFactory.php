<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pain;
use App\Specialty;
use Faker\Generator as Faker;

$factory->define(Pain::class, function (Faker $faker) {
    return [
        'title'=>$faker->name,
        'specialty_id'=>0

    ];
});
