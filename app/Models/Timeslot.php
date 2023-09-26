<?php

namespace App\Models;

use App\Http\Traits\CommonQueryScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Timeslot
 *
 * @property int $id
 * @property int $doctor_id
 * @property string $start_at
 * @property string $finish_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Patient[] $appointments
 * @property-read int|null $appointments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereFinishAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereUpdatedAt($value)
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereStartTime($value)
 * @method static Builder|Timeslot getAll(int $perPage = 10)
 * @mixin \Eloquent
 */
class Timeslot extends Model
{
    use HasFactory;
    use CommonQueryScope;

    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'doctor_id' => 'integer',
    ];

    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class);
    }
}
