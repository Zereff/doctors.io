<?php

namespace Tests\Feature;

use App\Models\Availability;
use App\Models\Doctor;
use App\Models\Timeslot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimeslotControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();

        Timeslot::factory(5)->create();

        $response = $this->get('/api/timeslots');

        $response->assertStatus(200);

        $response->assertJsonCount(5, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'doctor_id',
                    'date',
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
            'date' => $this->faker->date(),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
        ];

        $response = $this->post('/api/timeslots', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('timeslots', $data);

        $response->assertJson([
            'doctor_id' => $data['doctor_id'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
    }

    public function testUpdate(): void
    {
        $this->withoutExceptionHandling();

        $timeslot = Timeslot::factory()->create();

        $data = [
            'doctor_id' => $timeslot->doctor_id,
            'date' => $this->faker->date(),
            'start_time' => '10:00',
            'end_time' => '11:00',
        ];

        $response = $this->patch('/api/timeslots/' . $timeslot->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('timeslots', $data);

        $response->assertJson([
            'doctor_id' => $data['doctor_id'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();

        $timeslot = Timeslot::factory()->create();

        $response = $this->get('/api/timeslots/' . $timeslot->id);

        $response->assertStatus(200);

        $response->assertJson([
            'doctor_id' => $timeslot->doctor_id,
            'date' => $timeslot->date,
            'start_time' => $timeslot->start_time->format('H:i'),
            'end_time' => $timeslot->end_time->format('H:i'),
        ]);
    }

    public function testDelete(): void
    {
        $this->withoutExceptionHandling();

        $timeslot = Timeslot::factory()->create();

        $response = $this->delete('/api/timeslots/' . $timeslot->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('timeslots', ['id' => $timeslot->id]);
    }
}
