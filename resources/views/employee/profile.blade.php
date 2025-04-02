@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Profile</div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <!-- Profile picture placeholder -->
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px; margin: 0 auto;">
                                <i class="fas fa-user fa-3x text-secondary"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $user->name }}</h4>
                            <p class="mb-1"><strong>Position:</strong> {{ $user->position ?? 'Not specified' }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $user->phone ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="today-attendance mb-4">
                        <h5>Today's Attendance</h5>
                        @if($todayAttendance)
                            <div class="alert alert-{{ $todayAttendance->status === 1 ? 'success' : 'warning' }}">
                                <p><strong>Status:</strong> {{ $todayAttendance->getStatusText() }}</p>
                                <p><strong>Check In:</strong> 
                                    {{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : 'Not checked in' }}
                                </p>
                                <p><strong>Check Out:</strong> 
                                    {{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') : 'Not checked out' }}
                                </p>
                            </div>

                            @if(!$todayAttendance->check_out)
                                <form action="{{ route('attendance.checkOut') }}" method="POST" class="mb-3">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-sign-out-alt"></i> Check Out
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-info">
                                <p>You haven't checked in today.</p>
                                <form action="{{ route('attendance.checkIn') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-sign-in-alt"></i> Check In
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="recent-attendance">
                        <h5>Recent Attendance Records</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAttendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $attendance->status === 1 ? 'success' : ($attendance->status === 2 ? 'warning' : 'danger') }}">
                                                {{ $attendance->getStatusText() }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}</td>
                                        <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection