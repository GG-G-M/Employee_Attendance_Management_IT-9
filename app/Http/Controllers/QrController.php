<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrController extends Controller
{
    public function handleScan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $user = User::where('key', $request->qr_code)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid QR Code');
        }

        // Log the user in
        Auth::login($user);

        // Record attendance for employees
        if ($user->isEmployee()) {
            $this->recordEmployeeAttendance($user);
        }

        // Redirect based on role
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'hr' => redirect()->route('hr.dashboard'),
            'employee' => redirect()->route('employee.profile'),
            default => redirect()->back()->with('error', 'Unknown role'),
        };
    }

    protected function recordEmployeeAttendance($user)
    {
        $today = Carbon::today();
        $now = Carbon::now();
        
        // Check if already checked in today
        $attendance = Attendance::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            [
                'status' => $now->gt($today->copy()->setTimeFromTimeString($user->duty_time)->addMinutes(15)) 
                    ? 'late' 
                    : 'present',
                'check_in' => $now->toTimeString(),
            ]
        );

        // If already checked in but not checked out
        if ($attendance->check_in && !$attendance->check_out) {
            $attendance->update(['check_out' => $now->toTimeString()]);
        }
    }
}