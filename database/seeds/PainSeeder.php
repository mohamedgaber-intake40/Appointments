<?php

use App\Pain;
use App\Specialty;
use Illuminate\Database\Seeder;

class PainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialty::all()->each(function($specialty){
            factory(Pain::class,3)->create([
                'specialty_id'=>$specialty->id
            ]);
        });

    }
}
