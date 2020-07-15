<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SpecialtySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PainSeeder::class);
        $this->call(AppointmentSeeder::class);
    }
}
