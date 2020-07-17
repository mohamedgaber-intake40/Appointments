<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DoctorProfile;
use App\Specialty;
use Faker\Generator as Faker;

$factory->define(DoctorProfile::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastname,
        'email' => $faker->unique()->safeEmail,
        'specialty_id'=>rand(1,Specialty::count())
    ];
});
