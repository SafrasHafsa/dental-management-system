<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->string('patient_number', 20)->unique();   // PT-2024-00001
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('referred_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name']);
        });

        Schema::create('patient_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('patient_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['home', 'work', 'mobile', 'emergency']);
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('contact_name')->nullable();   // for emergency
            $table->string('relationship', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('patient_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('patient_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['home', 'work', 'billing'])->default('home');
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->default('Philippines');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('patient_medical_histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('recorded_by')->constrained('users')->restrictOnDelete();
            // Systemic conditions
            $table->boolean('has_heart_disease')->default(false);
            $table->boolean('has_diabetes')->default(false);
            $table->boolean('has_hypertension')->default(false);
            $table->boolean('has_thyroid_disorder')->default(false);
            $table->boolean('has_liver_disease')->default(false);
            $table->boolean('has_kidney_disease')->default(false);
            $table->boolean('has_blood_disorder')->default(false);
            $table->boolean('has_respiratory_disease')->default(false);
            // Medications
            $table->boolean('is_on_blood_thinners')->default(false);
            $table->boolean('is_on_steroids')->default(false);
            $table->text('current_medications')->nullable();
            // Allergies
            $table->text('drug_allergies')->nullable();
            $table->text('material_allergies')->nullable();
            // Dental history
            $table->text('previous_dental_work')->nullable();
            $table->date('last_dental_visit')->nullable();
            $table->text('oral_hygiene_habits')->nullable();
            // Women's health
            $table->boolean('is_pregnant')->default(false);
            $table->boolean('is_nursing')->default(false);
            $table->text('additional_notes')->nullable();
            $table->unsignedTinyInteger('version')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_medical_histories');
        Schema::dropIfExists('patient_addresses');
        Schema::dropIfExists('patient_contacts');
        Schema::dropIfExists('patients');
    }
};
