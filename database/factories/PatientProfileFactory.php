<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PatientProfile;
use Faker\Generator as Faker;

$factory->define(PatientProfile::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastname,
        'email' => $faker->unique()->safeEmail,
        'mobile' => $faker->e164PhoneNumber,
        'birthdate' =>$faker->date() ,
        'gender' =>rand(0,1),
        'country' => $faker->company,
        'occupation' =>$faker->jobTitle ,
    ];
});
