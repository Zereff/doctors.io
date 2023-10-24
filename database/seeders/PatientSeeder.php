<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run()
    {
        Patient::factory()->hasUser([
            'userable_type' => Patient::class,
            'role' => Role::Patient->value,
            'email' => 'patient@doctor.io',
        ])->create();

        Patient::factory(4)->hasUser([
            'userable_type' => Patient::class,
            'role' => Role::Patient->value,
        ])->create();
    }
}
