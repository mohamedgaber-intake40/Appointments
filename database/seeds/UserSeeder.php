<?php

use App\DoctorProfile;
use App\Enums\UserType;
use App\PatientProfile;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'user_name'=>'admin',
            'password'=>'12345678',
            'profileable_type'=>null,
            'profileable_id'=>null,
            'type'=>UserType::ADMIN
        ]);

        factory(PatientProfile::class,10)->create()->each(function($profile){
            factory(User::class)->create([
                'profileable_type'=>get_class($profile),
                'profileable_id'=>$profile->id,
                'type'=>UserType::PATIENT
            ]);
        });

        factory(DoctorProfile::class,10)->create()->each(function($profile){
            factory(User::class)->create([
                'profileable_type'=>get_class($profile),
                'profileable_id'=>$profile->id,
                'type'=>UserType::DOCTOR
            ]);
        });
    }
}
