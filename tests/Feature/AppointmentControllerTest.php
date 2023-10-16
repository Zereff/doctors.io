<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Timeslot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ActAsPatient;

class AppointmentControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use ActAsPatient;

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

        $timeslot = Timeslot::factory()->create();

        $data = [
            'timeslot_id' => $timeslot->id,
        ];

        $response = $this->post('/api/appointments', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('patient_timeslots', $data);

        $response->assertJson([
            'timeslot_id' => $data['timeslot_id'],
        ]);
    }

    public function testDelete()
    {
        $this->withoutExceptionHandling();

        $user = \Auth::user();
        $patient = Patient::findOrFail($user->userable_id);
        $appointment = Appointment::factory()->create(['patient_id' => $patient->id]);

        $response = $this->delete('/api/appointments/' . $appointment->id);

        $response->assertStatus(200);

        $this->assertSoftDeleted('patient_timeslots', ['id' => $appointment->id]);
    }
}
