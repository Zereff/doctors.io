<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        Doctor::factory(5)
            ->hasUser()
            ->has(Availability::factory(1))
            ->create();
    }
}
