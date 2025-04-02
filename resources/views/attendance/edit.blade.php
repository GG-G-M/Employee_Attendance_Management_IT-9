@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Attendance Record</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Employee</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $attendance->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   value="{{ $attendance->date->format('Y-m-d') }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="check_in" class="form-label">Check In</label>
                                <input type="time" class="form-control" id="check_in" name="check_in" 
                                       value="{{ $attendance->check_in }}">
                            </div>
                            <div class="col-md-6">
                                <label for="check_out" class="form-label">Check Out</label>
                                <input type="time" class="form-control" id="check_out" name="check_out" 
                                       value="{{ $attendance->check_out }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" {{ $attendance->status == 1 ? 'selected' : '' }}>Present</option>
                                <option value="2" {{ $attendance->status == 2 ? 'selected' : '' }}>Late</option>
                                <option value="3" {{ $attendance->status == 3 ? 'selected' : '' }}>Absent</option>
                                <option value="4" {{ $attendance->status == 4 ? 'selected' : '' }}>Holiday</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $attendance->notes }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection