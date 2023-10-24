<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PatientSeeder::class,
            DoctorSeeder::class,
        ]);

        Artisan::call('insert:admin');
    }
}
