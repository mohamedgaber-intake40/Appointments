<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Appointment;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        'patient_id'=>0,
        'doctor_id'=>0,
        'date'=>$faker->dateTime(),
        'pain_id'=>0,
        'is_patient_confirm'=>rand(0,1),
        'is_doctor_confirm'=>rand(0,1),
    ];
});
