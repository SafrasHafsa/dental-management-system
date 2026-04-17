<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();   // General, Ortho, Surgical...
            $table->unsignedSmallInteger('duration_minutes')->default(30);
            $table->decimal('base_price', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('specialization')->nullable();
            $table->string('license_number', 50)->nullable();
            $table->string('bio')->nullable();
            $table->timestamps();
        });

        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');    // 0=Sun … 6=Sat
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedSmallInteger('slot_duration_minutes')->default(30);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['doctor_profile_id', 'day_of_week']);
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('appointment_number', 20)->unique();  // APT-2024-00001
            $table->foreignUlid('patient_id')->constrained()->restrictOnDelete();
            $table->foreignId('doctor_profile_id')->constrained()->restrictOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUlid('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignUlid('approved_by')->nullable()->constrained('users')->nullOnDelete();

            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('chair_number', 10)->nullable();

            $table->enum('status', [
                'pending',      // customer booked, awaiting staff approval
                'confirmed',    // staff approved
                'in_progress',  // doctor started
                'completed',    // doctor finished
                'cancelled',    // cancelled by anyone
                'no_show',      // patient did not show
            ])->default('pending');

            $table->enum('source', ['online', 'walk_in', 'phone'])->default('online');
            $table->text('notes')->nullable();              // booking notes from patient
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['appointment_date', 'status']);
            $table->index(['patient_id', 'status']);
        });

        Schema::create('clinical_notes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('doctor_id')->constrained('users')->restrictOnDelete();
            $table->text('subjective')->nullable();     // What patient reports
            $table->text('objective')->nullable();      // What doctor observes
            $table->text('assessment')->nullable();     // Diagnosis
            $table->text('plan')->nullable();           // Treatment plan notes
            $table->text('procedures_done')->nullable();
            $table->timestamps();
        });

        Schema::create('appointment_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('appointment_id')->constrained()->cascadeOnDelete();
            $table->enum('channel', ['email', 'sms', 'in_app'])->default('email');
            $table->enum('type', ['confirmation', 'reminder_24h', 'reminder_1h', 'cancellation']);
            $table->timestamp('scheduled_at');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('failure_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_reminders');
        Schema::dropIfExists('clinical_notes');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('doctor_schedules');
        Schema::dropIfExists('doctor_profiles');
        Schema::dropIfExists('services');
    }
};
