@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.partials.sidebar')
        
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Dashboard</h1>
            </div>

            <div class="row mb-4">
                <!-- Stats Cards -->
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text display-4">{{ \App\Models\User::count() }}</p>
                            <a href="{{ route('admin.users') }}" class="text-white">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Today's Attendance</h5>
                            <p class="card-text display-4">{{ \App\Models\Attendance::whereDate('date', today())->count() }}</p>
                            <a href="{{ route('attendance.index') }}" class="text-white">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Active Employees</h5>
                            <p class="card-text display-4">{{ \App\Models\User::where('role', 'employee')->count() }}</p>
                            <a href="{{ route('admin.users') }}?role=employee" class="text-white">View All</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Attendance Section -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Attendance</span>
                    <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(isset($recentAttendances) && $recentAttendances->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAttendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->user->name ?? 'N/A' }}</td>
                                        <td>{{ $attendance->date->format('Y-m-d') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'late' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->check_in }}</td>
                                        <td>{{ $attendance->check_out ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No attendance records found.</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Quick Actions</span>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary me-2">
                        <i class="fas fa-user-plus"></i> Add New User
                    </a>
                    <a href="{{ route('attendance.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-calendar-check"></i> View Attendance
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn btn-info">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection