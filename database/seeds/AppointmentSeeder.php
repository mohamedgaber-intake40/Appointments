<?php

use App\Appointment;
use App\Pain;
use App\PatientProfile;
use App\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where('profileable_type', 'App\\'.DoctorProfile::class)->get()
        ->each(function ($doctor) {
            User::where('profileable_type', PatientProfile::class)
            ->inRandomOrder()
            ->take(5)
            ->get()
            ->each(function ($patient) use ($doctor)
            {
                $pains = $doctor->profileable->specialty->pains->toArray();
                $pain  = $pains[array_rand($pains)];
                factory(Appointment::class,1)->create([
                    'patient_id'=>$patient->id,
                    'doctor_id'=>$doctor->id,
                    'pain_id'=>$pain['id'],
                ]);
            });

        });

    }
}
