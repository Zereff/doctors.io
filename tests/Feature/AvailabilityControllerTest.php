<?php

namespace Tests\Feature;

use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ActAsLoggedUser;

class AvailabilityControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use ActAsLoggedUser;

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();

        Doctor::factory()->has(Availability::factory(5))->create();

        $response = $this->get('/api/availabilities');

        $response->assertStatus(200);

        $response->assertJsonCount(5, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'doctor_id',
                    'day_of_week',
                    'start_time',
                    'end_time',
                ],
            ],
        ]);
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();

        $doctor = Doctor::factory()->create();

        $data = [
            'doctor_id' => $doctor->id,
            'day_of_week' => $this->faker->numberBetween(1, 5),
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $response = $this->post('/api/availabilities', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('availabilities', $data);

        $response->assertJson([
            'doctor_id' => $data['doctor_id'],
            'day_of_week' => $data['day_of_week'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
    }

    public function testUpdate(): void
    {
        $this->withoutExceptionHandling();

        $availability = Availability::factory()->create();

        $data = [
            'start_time' => '10:00',
            'end_time' => '14:00',
        ];

        $response = $this->patch('/api/availabilities/' . $availability->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('availabilities', $data);

        $response->assertJson([
            'doctor_id' => $availability->doctor_id,
            'day_of_week' => $availability->day_of_week,
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();

        $availability = Availability::factory()->create();

        $response = $this->get('/api/availabilities/' . $availability->id);

        $response->assertStatus(200);

        $response->assertJson([
            'doctor_id' => $availability->doctor_id,
            'day_of_week' => $availability->day_of_week,
            'start_time' => $availability->start_time->format('H:i'),
            'end_time' => $availability->end_time->format('H:i'),
        ]);
    }

    public function testDelete(): void
    {
        $this->withoutExceptionHandling();

        $availability = Availability::factory()->create();

        $response = $this->delete('/api/availabilities/' . $availability->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('availabilities', ['id' => $availability->id]);
    }
}
