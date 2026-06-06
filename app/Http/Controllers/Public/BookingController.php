<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $doctors  = DoctorProfile::with('user')->get();

        return view('public.booking', compact('services', 'doctors'));
    }

    public function slots(Request $request)
    {
        // Returns available time slots as JSON for AJAX calls
        $request->validate([
            'doctor_id' => 'required|exists:doctor_profiles,id',
            'date'      => 'required|date|after_or_equal:today',
        ]);

        $doctor   = DoctorProfile::findOrFail($request->doctor_id);
        $date     = \Carbon\Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeek;

        $schedule = $doctor->schedules()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (! $schedule) {
            return response()->json(['slots' => []]);
        }

        // Generate slots
        $slots  = [];
        $start  = \Carbon\Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->start_time);
        $end    = \Carbon\Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->end_time);
        $duration = $schedule->slot_duration_minutes;

        // Get already-booked slots
        $booked = Appointment::where('doctor_profile_id', $doctor->id)
            ->whereDate('appointment_date', $date)
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->pluck('start_time')
            ->map(fn($t) => substr($t, 0, 5))
            ->toArray();

        while ($start->lt($end)) {
            $time = $start->format('H:i');
            $slots[] = [
                'time'      => $time,
                'label'     => $start->format('g:i A'),
                'available' => ! in_array($time, $booked),
            ];
            $start->addMinutes($duration);
        }

        return response()->json(['slots' => $slots]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'doctor_id'   => 'required|exists:doctor_profiles,id',
            'service_id'  => 'nullable|exists:services,id',
            'date'        => 'required|date|after_or_equal:today',
            'time'        => 'required',
            'notes'       => 'nullable|string|max:500',
            // If guest
            'first_name'  => Auth::check() ? 'nullable' : 'required|string|max:100',
            'last_name'   => Auth::check() ? 'nullable' : 'required|string|max:100',
            'email'       => Auth::check() ? 'nullable' : 'required|email',
            'phone'       => Auth::check() ? 'nullable' : 'required|string|max:20',
        ]);

        DB::transaction(function () use ($request, &$appointment) {
            // Get or create patient
            if (Auth::check() && Auth::user()->patient) {
                $patient = Auth::user()->patient;
            } else {
                // Guest booking — create user+patient or find by email
                $user = \App\Models\User::firstOrCreate(
                    ['email' => $request->email],
                    [
                        'name'     => $request->first_name . ' ' . $request->last_name,
                        'phone'    => $request->phone,
                        'password' => bcrypt(\Illuminate\Support\Str::random(12)),
                    ]
                );
                if (! $user->patient) {
                    $user->roles()->syncWithoutDetaching([\App\Models\Role::where('name', 'patient')->first()->id]);
                    
                    // Generate unique patient number
                    $lastPatient = \App\Models\Patient::withTrashed()
                        ->orderByDesc('created_at')
                        ->first();
                    $nextNumber  = $lastPatient
                        ? (intval(substr($lastPatient->patient_number, -5)) + 1)
                        : 1;
                    $patientNumber = 'PT-' . date('Y') . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                    // Make sure it's unique
                    while (\App\Models\Patient::withTrashed()->where('patient_number', $patientNumber)->exists()) {
                        $nextNumber++;
                        $patientNumber = 'PT-' . date('Y') . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
                    }

                    $user->patient()->create([
                        'patient_number' => $patientNumber,
                        'first_name'     => $request->first_name,
                        'last_name'      => $request->last_name,
                    ]);
                }
                $patient = $user->fresh()->patient;
            }

            $doctor  = \App\Models\DoctorProfile::findOrFail($request->doctor_id);
            $service = $request->service_id ? \App\Models\Service::find($request->service_id) : null;
            $duration = $service?->duration_minutes ?? 30;

            $number = 'APT-' . date('Y') . '-' . str_pad(\App\Models\Appointment::withTrashed()->count() + 1, 5, '0', STR_PAD_LEFT);

            $start = \Carbon\Carbon::parse($request->date . ' ' . $request->time);
            $end   = $start->copy()->addMinutes($duration);

            $appointment = \App\Models\Appointment::create([
                'appointment_number' => $number,
                'patient_id'         => $patient->id,
                'doctor_profile_id'  => $doctor->id,
                'service_id'         => $service?->id,
                'created_by'         => Auth::id() ?? $patient->user_id,
                'appointment_date'   => $request->date,
                'start_time'         => $start->format('H:i:s'),
                'end_time'           => $end->format('H:i:s'),
                'status'             => 'pending',
                'source'             => 'online',
                'notes'              => $request->notes,
            ]);
        });

        return redirect()->route('book.confirm', $appointment)
            ->with('success', 'Your appointment has been submitted and is awaiting confirmation.');
    }

    public function confirm(Appointment $appointment): View
    {
        return view('public.booking-confirm', compact('appointment'));
    }
}
