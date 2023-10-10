<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Timeslot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ActAsLoggedUser;

class AppointmentControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use ActAsLoggedUser;

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();

        Appointment::factory()->create();

        $response = $this->get('/api/appointments');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'patient_id',
                    'timeslot_id',
                    'deleted_at',
                ],
            ],
        ]);
    }

    public function testStore()
    {
        $this->withoutExceptionHandling();

        $patient = Patient::factory()->create();
        $timeslot = Timeslot::factory()->create();

        $data = [
            'patient_id' => $patient->id,
            'timeslot_id' => $timeslot->id,
        ];

        $response = $this->post('/api/appointments', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('patient_timeslots', $data);

        $response->assertJson([
            'patient_id' => $data['patient_id'],
            'timeslot_id' => $data['timeslot_id'],
        ]);
    }

    public function testDelete()
    {
        $this->withoutExceptionHandling();

        $appointment = Appointment::factory()->create();

        $response = $this->delete('/api/appointments/' . $appointment->id);

        $response->assertStatus(200);

        $this->assertSoftDeleted('patient_timeslots', ['id' => $appointment->id]);
    }
}
