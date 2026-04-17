<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientContact extends Model
{
    protected $fillable = ['patient_id', 'type', 'phone', 'email', 'is_primary', 'contact_name', 'relationship'];

    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
}
