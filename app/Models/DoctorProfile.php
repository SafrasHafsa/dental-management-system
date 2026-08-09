<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorProfile extends Model
{
    protected $fillable = ['user_id', 'specialization', 'license_number', 'bio'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function fullName(): string
    {
        return 'Dr. ' . $this->user->name;
    }

    /**
     * Only doctors whose linked user account is active
     * and still holds the "doctor" role. Use this anywhere
     * a doctor picker/dropdown is built, so deactivated or
     * reassigned users drop out automatically.
     */
    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('is_active', true)
              ->whereHas('roles', fn($q2) => $q2->where('name', 'doctor'));
        });
    }
}