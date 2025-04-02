<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HrController extends Controller
{
    public function dashboard(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        
        return view('hr.dashboard', [
            'attendances' => Attendance::with('user')
                ->whereDate('date', $date)
                ->paginate(20),
            'employees' => User::where('role', 'employee')->get(),
            'selectedDate' => $date
        ]);
    }

    public function updateAttendance(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status' => 'required|in:present,late,absent,holiday',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'notes' => 'nullable|string'
        ]);

        $attendance->update($validated);

        return back()->with('success', 'Attendance updated');
    }
}