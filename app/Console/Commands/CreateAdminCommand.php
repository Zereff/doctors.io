<?php

namespace App\Console\Commands;

use App\Enums\Gender;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    protected $signature = 'insert:admin';

    protected $description = 'Create admin in database';

    public function handle(): void
    {
        User::create([
            'userable_id' => null,
            'userable_type' => null,
            'role' => Role::Admin->value,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@doctor.io',
            'phone' => '+37378059109',
            'gender' => Gender::Male->value,
            'birthday' => '2001-01-01',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        dd('admin was created');
    }
}
