<?php

namespace Tests\Traits;

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
            'role' => User::ROLE_ADMIN,
        ]);

        $this->actingAs($user);
    }
}
