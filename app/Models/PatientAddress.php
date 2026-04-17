<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientAddress extends Model
{
    protected $fillable = ['patient_id', 'type', 'line1', 'line2', 'city', 'state', 'postal_code', 'country', 'is_primary'];

    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
}
