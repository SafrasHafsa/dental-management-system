<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ClinicSetting;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $doctor    = Auth::user()->doctorProfile;
        $schedules = $doctor->schedules()->orderBy('day_of_week')->get()->keyBy('day_of_week');

        $clinicOpen  = ClinicSetting::get('working_hours_start', '08:00');
        $clinicClose = ClinicSetting::get('working_hours_end', '17:00');

        return view('doctor.schedule', compact('schedules', 'clinicOpen', 'clinicClose'));
    }

    public function update(Request $request)
    {
        $clinicOpen  = ClinicSetting::get('working_hours_start', '08:00');
        $clinicClose = ClinicSetting::get('working_hours_end', '17:00');

        $request->validate([
            'days'                  => 'nullable|array',
            'days.*'                => 'integer|between:0,6',
            'start_time'            => [
                'required',
                'date_format:H:i',
                'after_or_equal:' . $clinicOpen,
                'before:end_time',
            ],
            'end_time'              => [
                'required',
                'date_format:H:i',
                'after:start_time',
                'before_or_equal:' . $clinicClose,
            ],
            'slot_duration_minutes' => 'required|integer|in:15,20,30,45,60',
        ], [
            'start_time.after_or_equal' => "Start time cannot be earlier than the clinic's opening time ({$clinicOpen}).",
            'end_time.before_or_equal'  => "End time cannot be later than the clinic's closing time ({$clinicClose}).",
        ]);

        $doctor     = Auth::user()->doctorProfile;
        $activeDays = $request->input('days', []);

        foreach (range(0, 6) as $day) {
            DoctorSchedule::updateOrCreate(
                ['doctor_profile_id' => $doctor->id, 'day_of_week' => $day],
                [
                    'start_time'            => $request->start_time . ':00',
                    'end_time'              => $request->end_time . ':00',
                    'slot_duration_minutes' => $request->slot_duration_minutes,
                    'is_active'             => in_array($day, $activeDays),
                ]
            );
        }

        return back()->with('success', 'Schedule updated successfully.');
    }
}