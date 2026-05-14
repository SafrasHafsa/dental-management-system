<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $doctor    = Auth::user()->doctorProfile;
        $schedules = $doctor->schedules()->orderBy('day_of_week')->get()->keyBy('day_of_week');

        return view('doctor.schedule', compact('schedules'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'days'                  => 'nullable|array',
            'days.*'                => 'integer|between:0,6',
            'start_time'            => 'required|date_format:H:i',
            'end_time'              => 'required|date_format:H:i|after:start_time',
            'slot_duration_minutes' => 'required|integer|in:15,20,30,45,60',
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