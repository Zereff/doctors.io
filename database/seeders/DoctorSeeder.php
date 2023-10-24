<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        Doctor::factory()
            ->hasUser(['email' => 'doctor@doctor.io'])
            ->has(Availability::factory(1))
            ->create();

        Doctor::factory(4)
            ->hasUser()
            ->has(Availability::factory(1))
            ->create();
    }
}
