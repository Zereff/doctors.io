<?php

namespace Tests\Traits;

use App\Enums\Role;
use App\Models\Patient;
use App\Models\User;

trait ActAsPatient
{
    public function setUp(): void
    {
        parent::setUp();

        $this->actAsPatient();
    }

    public function actAsPatient(): void
    {
        $user = User::factory()->create([
            'userable_id' => Patient::factory(),
            'userable_type' => Patient::class,
            'role' => Role::Patient->value,
        ]);


        $this->actingAs($user);
    }
}
