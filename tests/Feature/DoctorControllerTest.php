<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DoctorControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();

        Doctor::factory()->has(User::factory())->count(10)->create();

        $response = $this->get('/api/doctors');

        $response->assertStatus(200);

        $response->assertJsonCount(10, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'specialty',
                    'description',
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
            'gender' => User::GENDER_MALE,
            'birthday' => $this->faker->date(),
            'password' => 'password',
            'password_confirmation' => 'password',
            'specialty' => 'Cardiology',
            'description' => 'Experienced cardiologist',
        ];

        $response = $this->post('/api/doctors', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('doctors', [
            'specialty' => $data['specialty'],
            'description' => $data['description'],
        ]);

        $this->assertDatabaseHas('users', [
            'role' => User::ROLE_DOCTOR,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'birthday' => $data['birthday'],
        ]);

        $response->assertJson([
            'specialty' => $data['specialty'],
            'description' => $data['description'],
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

        $doctor = Doctor::factory()->has(User::factory())->create();

        $data = [
            'specialty' => 'Updated Specialty',
            'description' => 'Updated Description',
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'gender' => User::GENDER_MALE,
            'birthday' => $this->faker->date(),
        ];

        $response = $this->patch('/api/doctors/' . $doctor->id, $data);

        $response->assertStatus(200);

        $doctor->refresh();

        $this->assertEquals($data['specialty'], $doctor->specialty);
        $this->assertEquals($data['description'], $doctor->description);
        $this->assertEquals($data['first_name'], $doctor->user->first_name);
        $this->assertEquals($data['last_name'], $doctor->user->last_name);
        $this->assertEquals($data['email'], $doctor->user->email);
        $this->assertEquals($data['phone'], $doctor->user->phone);
        $this->assertEquals($data['gender'], $doctor->user->gender);
        $this->assertEquals($data['birthday'], $doctor->user->birthday);

        $response->assertJson([
            'specialty' => $data['specialty'],
            'description' => $data['description'],
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

    public function testShow(): void
    {
        $this->withoutExceptionHandling();

        $doctor = Doctor::factory()->has(User::factory())->create();

        $response = $this->get('/api/doctors/' . $doctor->id);

        $response->assertStatus(200);

        $response->assertJson([
            'specialty' => $doctor->specialty,
            'description' => $doctor->description,
            'user' => [
                'first_name' => $doctor->user->first_name,
                'last_name' => $doctor->user->last_name,
                'email' => $doctor->user->email,
                'phone' => $doctor->user->phone,
                'gender' => $doctor->user->gender,
                'birthday' => $doctor->user->birthday,
            ],
        ]);
    }

    public function testDelete(): void
    {
        $this->withoutExceptionHandling();

        $doctor = Doctor::factory()->has(User::factory())->create();
        $user = $doctor->user;

        $response = $this->delete('/api/doctors/' . $doctor->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('doctors', ['id' => $doctor->id]);
        $this->assertDatabaseMissing('users', ['userable_id' => $user->userable_id]);
    }
}
