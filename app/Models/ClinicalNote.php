<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicalNote extends Model
{
    use HasUlids;

    protected $fillable = ['appointment_id', 'doctor_id', 'subjective', 'objective', 'assessment', 'plan', 'procedures_done'];

    public function appointment(): BelongsTo { return $this->belongsTo(Appointment::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(User::class, 'doctor_id'); }
}
