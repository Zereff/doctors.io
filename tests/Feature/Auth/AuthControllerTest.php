<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

   public function testLogin()
   {
       $this->withoutExceptionHandling();

       $user = User::factory()->create(['userable_id' => rand(1, 9999)]);

       $response = $this->post('/api/login', [
           'email' => $user->email,
           'password' => 'password',
           'password_confirmation' => 'password',
       ]);

       $this->assertAuthenticated();
       $response->assertOk();
   }
}
