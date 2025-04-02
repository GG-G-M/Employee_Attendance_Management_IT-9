@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Attendance Records</h5>
                    
                    @if(auth()->user()->isEmployee())
                        <div>
                            @if(!$todayAttendance)
                                <a href="{{ route('attendance.checkIn') }}" class="btn btn-success">
                                    <i class="fas fa-sign-in-alt"></i> Check In
                                </a>
                            @elseif(!$todayAttendance->check_out)
                                <a href="{{ route('attendance.checkOut') }}" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt"></i> Check Out
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    @if(auth()->user()->isAdmin() || auth()->user()->isHR())
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="date" name="date" class="form-control" 
                                       value="{{ request('date', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isHR())
                                        <th>Employee</th>
                                    @endif
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Notes</th>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isHR())
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                <tr>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isHR())
                                        <td>{{ $attendance->user->name }}</td>
                                    @endif
                                    <td>{{ $attendance->date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $attendance->status === 1 ? 'success' : ($attendance->status === 2 ? 'warning' : 'danger') }}">
                                            {{ $attendance->getStatusText() }}
                                        </span>
                                    </td>
                                    <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}</td>
                                    <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}</td>
                                    <td>{{ $attendance->notes ?? '-' }}</td>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isHR())
                                        <td>
                                            <a href="{{ route('attendance.edit', $attendance->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection