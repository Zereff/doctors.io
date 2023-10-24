<?php

namespace Tests\Traits;

use App\Enums\Role;
use App\Models\User;

trait ActAsAdmin
{
    public function setUp(): void
    {
        parent::setUp();

        $this->actAsAdmin();
    }

    public function actAsAdmin(): void
    {
        $user = User::factory()->create([
            'userable_id' => null,
            'userable_type' => null,
            'role' => Role::Admin->value,
        ]);

        $this->actingAs($user);
    }
}
