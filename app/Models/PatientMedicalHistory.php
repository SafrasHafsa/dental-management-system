<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientMedicalHistory extends Model
{
    use HasUlids;

    protected $fillable = [
        'patient_id', 'recorded_by',
        'has_heart_disease', 'has_diabetes', 'has_hypertension',
        'has_thyroid_disorder', 'has_liver_disease', 'has_kidney_disease',
        'has_blood_disorder', 'has_respiratory_disease',
        'is_on_blood_thinners', 'is_on_steroids', 'current_medications',
        'drug_allergies', 'material_allergies',
        'previous_dental_work', 'last_dental_visit', 'oral_hygiene_habits',
        'is_pregnant', 'is_nursing', 'additional_notes',
    ];

    protected function casts(): array
    {
        return [
            'has_heart_disease'       => 'boolean',
            'has_diabetes'            => 'boolean',
            'has_hypertension'        => 'boolean',
            'has_thyroid_disorder'    => 'boolean',
            'has_liver_disease'       => 'boolean',
            'has_kidney_disease'      => 'boolean',
            'has_blood_disorder'      => 'boolean',
            'has_respiratory_disease' => 'boolean',
            'is_on_blood_thinners'    => 'boolean',
            'is_on_steroids'          => 'boolean',
            'is_pregnant'             => 'boolean',
            'is_nursing'              => 'boolean',
            'last_dental_visit'       => 'date',
        ];
    }

    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function recordedBy(): BelongsTo { return $this->belongsTo(User::class, 'recorded_by'); }
}
