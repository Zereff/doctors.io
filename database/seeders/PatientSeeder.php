<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run()
    {
        Patient::factory(5)->hasUser([
            'userable_type' => Patient::class,
            'role' => User::ROLE_PATIENT,
        ])->create();
    }
}
