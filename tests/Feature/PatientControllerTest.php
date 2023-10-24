<?php

namespace Tests\Feature;

use App\Enums\Gender;
use App\Enums\Role;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ActAsAdmin;

class PatientControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use ActAsAdmin;

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();

        Patient::factory()->has(User::factory())->count(10)->create();

        $response = $this->get('/api/patients');

        $response->assertStatus(200);

        $response->assertJsonCount(10, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'disease_history',
                    'user' => [
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'gender',
                        'birthday',
                    ],
                ],
            ],
        ]);
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'gender' => Gender::Male->value,
            'birthday' => $this->faker->date(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/patients', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'role' => Role::Patient->value,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'birthday' => $data['birthday'],
        ]);

        $response->assertJson([
            'disease_history' => null,
            'user' => [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'birthday' => $data['birthday'],
            ],
        ]);
    }

    public function testUpdate(): void
    {
        $this->withoutExceptionHandling();

        $patient = Patient::factory()->has(User::factory())->create(['disease_history' => null]);

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'gender' => Gender::Male->value,
            'birthday' => $this->faker->date(),
        ];

        $response = $this->patch('/api/patients/' . $patient->id, $data);

        $response->assertStatus(200);

        $patient->refresh();

        $this->assertEquals($data['first_name'], $patient->user->first_name);
        $this->assertEquals($data['last_name'], $patient->user->last_name);
        $this->assertEquals($data['email'], $patient->user->email);
        $this->assertEquals($data['phone'], $patient->user->phone);
        $this->assertEquals($data['gender'], $patient->user->gender);
        $this->assertEquals($data['birthday'], $patient->user->birthday);

        $response->assertJson([
            'user' => [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'birthday' => $data['birthday'],
            ],
        ]);
    }

    public function testUpdateActedAsDoctor()
    {
        $this->withoutExceptionHandling();
        $this->actAsDoctor();

        $patient = Patient::factory()->has(User::factory())->create();

        $data = [
            'disease_history' => $this->faker->text,
        ];

        $response = $this->patch('/api/patients/' . $patient->id, $data);
        $response->assertStatus(200);

        $patient->refresh();

        $this->assertEquals($data['disease_history'], $patient->disease_history);

        $response->assertJson([
            'disease_history' => $data['disease_history'],
        ]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();

        $patient = Patient::factory()->has(User::factory())->create();

        $response = $this->get('/api/patients/'. $patient->id);

        $response->assertStatus(200);

        $response->assertJson([
            'disease_history' => $patient->disease_history,
            'user' => [
                'first_name' => $patient->user->first_name,
                'last_name' =>$patient->user->last_name,
                'email' => $patient->user->email,
                'phone' => $patient->user->phone,
                'gender' => $patient->user->gender,
                'birthday' => $patient->user->birthday,
            ],
        ]);
    }

    public function testDelete(): void
    {
        $this->withoutExceptionHandling();

        $patient = Patient::factory()->has(User::factory())->create();
        $user = $patient->user;

        $response = $this->delete('/api/patients/' . $patient->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
        $this->assertDatabaseMissing('users', ['userable_id' => $user->userable_id]);
    }

    private function actAsDoctor(): void
    {
        $doctor = Doctor::factory()->has(User::factory())->create();
        $user = $doctor->user;

        $this->actingAs($user);
    }
}
