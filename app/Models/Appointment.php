<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'patient_timeslots';

    protected $fillable = [
        'patient_id',
        'timeslot_id'
    ];
}
