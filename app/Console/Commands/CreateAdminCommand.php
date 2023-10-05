<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    protected $signature = 'app:create-admin';

    protected $description = 'Create admin in database';

    public function handle(): void
    {
        User::create([
            'userable_id' => null,
            'userable_type' => null,
            'role' => User::ROLE_ADMIN,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@doctor.io',
            'phone' => '+37378059109',
            'gender' => User::GENDER_MALE,
            'birthday' => '2001-01-01',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        dd('admin was created');
    }
}
