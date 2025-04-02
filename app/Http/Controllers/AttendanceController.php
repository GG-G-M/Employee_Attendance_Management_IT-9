<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Employee check-in
    public function checkIn()
    {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');

        $existing = Attendance::where('user_id', $user->id)
                            ->whereDate('date', $today)
                            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        $checkInTime = Carbon::now();
        $status = $this->determineStatus($checkInTime);

        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'status' => $status,
            'check_in' => $checkInTime->format('H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Checked in successfully!');
    }

    // Employee check-out
    public function checkOut()
    {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');

        $attendance = Attendance::where('user_id', $user->id)
                            ->whereDate('date', $today)
                            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'You need to check in first.');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'You have already checked out today.');
        }

        $attendance->update([
            'check_out' => Carbon::now()->format('H:i:s')
        ]);

        return redirect()->back()->with('success', 'Checked out successfully!');
    }

    // Admin/HR edit view
    public function edit(Attendance $attendance)
    {
        $this->authorize('update', $attendance);
        $users = User::all();
        return view('attendance.edit', compact('attendance', 'users'));
    }

    // Admin/HR update
    public function update(Request $request, Attendance $attendance)
    {
        $this->authorize('update', $attendance);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:1,2,3,4',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'notes' => 'nullable|string'
        ]);

        $attendance->update($validated);

        return redirect()->route('attendance.index')
                        ->with('success', 'Attendance record updated successfully!');
    }

    // Determine if check-in is late
    protected function determineStatus($checkInTime)
    {
        $lateThreshold = Carbon::today()->setTime(9, 15, 0); // 9:15 AM is late
        return $checkInTime->gt($lateThreshold) ? 
            Attendance::STATUS_LATE : 
            Attendance::STATUS_PRESENT;
    }

    
}