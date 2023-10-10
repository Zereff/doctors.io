<?php

namespace Tests\Traits;

use App\Models\User;

trait ActAsLoggedUser
{
    public function setUp(): void
    {
        parent::setUp();

        $this->actAsUser();
    }

    public function actAsUser(string $role = User::ROLE_ADMIN)
    {
        $user = User::factory()->create([
            'userable_id' => null,
            'userable_type' => null,
            'role' => $role,
        ]);

        $this->actingAs($user);
    }
}
