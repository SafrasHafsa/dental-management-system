<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorSchedule extends Model
{
    protected $fillable = ['doctor_profile_id', 'day_of_week', 'start_time', 'end_time', 'slot_duration_minutes', 'is_active'];

    public function doctorProfile(): BelongsTo { return $this->belongsTo(DoctorProfile::class); }

    public function dayName(): string
    {
        return ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][$this->day_of_week];
    }
}
