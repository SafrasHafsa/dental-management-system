<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Notify staff and admin when a patient books an appointment
     */
    public static function appointmentBooked(Appointment $appointment): void
    {
        $staffAndAdmins = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['staff', 'admin']);
        })->get();

        foreach ($staffAndAdmins as $user) {
            // Route to the correct dashboard's appointment page based on
            // this specific recipient's role — admins and staff have
            // separate appointment detail routes/views.
            $url = $user->isAdmin()
                ? route('admin.appointments.show', $appointment)
                : route('staff.appointments.show', $appointment);

            self::create($user->id, [
                'title'   => 'New Appointment Booked',
                'message' => "New appointment booked by {$appointment->patient->first_name} {$appointment->patient->last_name} on " .
                             $appointment->appointment_date->format('M d, Y') . " at " .
                             \Carbon\Carbon::parse($appointment->start_time)->format('g:i A'),
                'url'     => $url,
                'icon'    => 'calendar',
            ]);
        }
    }

    /**
     * Notify patient when appointment is approved
     */
    public static function appointmentApproved(Appointment $appointment): void
    {
        if ($appointment->patient?->user) {
            self::create($appointment->patient->user->id, [
                'title'   => 'Appointment Confirmed',
                'message' => "Your appointment on " . $appointment->appointment_date->format('M d, Y') .
                             " at " . \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') .
                             " has been confirmed.",
                'url'     => route('patient.appointments'),
                'icon'    => 'check',
            ]);
        }

        // Also notify doctor
        if ($appointment->doctorProfile?->user) {
            self::create($appointment->doctorProfile->user->id, [
                'title'   => 'New Appointment Assigned',
                'message' => "New appointment with {$appointment->patient->first_name} {$appointment->patient->last_name} on " .
                             $appointment->appointment_date->format('M d, Y') . " at " .
                             \Carbon\Carbon::parse($appointment->start_time)->format('g:i A'),
                'url'     => route('doctor.appointments.show', $appointment),
                'icon'    => 'calendar',
            ]);
        }
    }

    /**
     * Notify patient when appointment is cancelled
     */
    public static function appointmentCancelled(Appointment $appointment): void
    {
        if ($appointment->patient?->user) {
            self::create($appointment->patient->user->id, [
                'title'   => 'Appointment Cancelled',
                'message' => "Your appointment on " . $appointment->appointment_date->format('M d, Y') .
                             " at " . \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') .
                             " has been cancelled.",
                'url'     => route('patient.appointments'),
                'icon'    => 'x',
            ]);
        }
    }

    /**
     * Notify patient when appointment is completed and invoice is created
     */
    public static function invoiceCreated(Appointment $appointment): void
    {
        if ($appointment->patient?->user && $appointment->invoice) {
            self::create($appointment->patient->user->id, [
                'title'   => 'Invoice Ready',
                'message' => "Your invoice {$appointment->invoice->invoice_number} for Rs." .
                             number_format($appointment->invoice->total_amount, 2) . " is ready.",
                'url'     => route('patient.invoices.show', $appointment->invoice),
                'icon'    => 'receipt',
            ]);
        }
    }

    /**
     * Create a notification record
     */
    private static function create(string $userId, array $data): void
    {
        DB::table('notifications')->insert([
            'id'               => \Illuminate\Support\Str::ulid(),
            'type'             => 'App\Notifications\GeneralNotification',
            'notifiable_type'  => 'App\Models\User',
            'notifiable_id'    => $userId,
            'data'             => json_encode($data),
            'read_at'          => null,
            'created_at'       => now(),

        ]);
    }
}