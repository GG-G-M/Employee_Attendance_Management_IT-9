<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        
        return view('employee.profile', [
            'todayAttendance' => $user->attendances()
                ->whereDate('date', Carbon::today())
                ->first(),
            'recentAttendances' => $user->attendances()
                ->latest()
                ->take(10)
                ->get()
        ]);
    }
}