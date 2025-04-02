@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Add New User
        </div>
        @if (Session::has('fail'))
            <span class="alert alert-danger p-2">
                {{ Session::get('fail') }}
            </span>
        @endif
        <div class="card-body"> 
            <form action="{{ route('admin.users.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" id="name" placeholder="Enter Full Name">
                    @error('full_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" id="email" placeholder="Enter Email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="form-control" id="phone" placeholder="Enter Phone Number">
                    @error('phone_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="confirm_password" placeholder="Confirm Password">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-control" id="role">
                        <option value="admin">Admin</option>
                        <option value="hr">HR</option>
                        <option value="employee">Employee</option>
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection