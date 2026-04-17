<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'appointment_number', 'patient_id', 'doctor_profile_id',
        'service_id', 'created_by', 'approved_by',
        'appointment_date', 'start_time', 'end_time',
        'chair_number', 'status', 'source', 'notes',
        'cancellation_reason', 'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'approved_at'      => 'datetime',
        ];
    }

    // ─── Status constants ─────────────────────────────────────

    const STATUS_PENDING     = 'pending';
    const STATUS_CONFIRMED   = 'confirmed';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED   = 'completed';
    const STATUS_CANCELLED   = 'cancelled';
    const STATUS_NO_SHOW     = 'no_show';

    // ─── Relationships ────────────────────────────────────────

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function clinicalNote(): HasOne
    {
        return $this->hasOne(ClinicalNote::class);
    }

    public function clinicalNotes(): HasMany
    {
        return $this->hasMany(ClinicalNote::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(AppointmentReminder::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    // ─── Status helpers ───────────────────────────────────────

    public function isPending(): bool     { return $this->status === self::STATUS_PENDING; }
    public function isConfirmed(): bool   { return $this->status === self::STATUS_CONFIRMED; }
    public function isInProgress(): bool  { return $this->status === self::STATUS_IN_PROGRESS; }
    public function isCompleted(): bool   { return $this->status === self::STATUS_COMPLETED; }
    public function isCancelled(): bool   { return $this->status === self::STATUS_CANCELLED; }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING     => 'badge-yellow',
            self::STATUS_CONFIRMED   => 'badge-blue',
            self::STATUS_IN_PROGRESS => 'badge-purple',
            self::STATUS_COMPLETED   => 'badge-green',
            self::STATUS_CANCELLED   => 'badge-red',
            self::STATUS_NO_SHOW     => 'badge-gray',
            default                  => 'badge-gray',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING     => 'Pending',
            self::STATUS_CONFIRMED   => 'Confirmed',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED   => 'Completed',
            self::STATUS_CANCELLED   => 'Cancelled',
            self::STATUS_NO_SHOW     => 'No Show',
            default                  => ucfirst($this->status),
        };
    }
}
