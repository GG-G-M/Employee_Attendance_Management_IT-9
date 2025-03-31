<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add New User</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Add New User
            </div>
            @if (Session::has('fail'))
                <span class="alert alert-danger p-2">
                    {{Session::get('fail')}}
                </span>
            @endif
            <div class="card-body"> 
                <form action="{{ route('addUser')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="full_name" value="{{old('full_name')}}" class="form-control" id="name" placeholder="Enter Full Name">
                        @error('full_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Email</label>
                        <input type="text" name="email" value="{{old('email')}}" class="form-control" id="name" placeholder="Enter Email">
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" value="{{old('phone_number')}}" class="form-control" id="name" placeholder="Enter Phone Number">
                        @error('phone_number')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Password</label>
                        <input type="text" name="password" value="{{old('password')}}" class="form-control" id="name" placeholder="Enter Password">
                        @error('password')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Confirm Password</label>
                        <input type="text" name="password_confirmation" class="form-control" id="name" placeholder="Confirm Password">
                        @error('password_confirmation')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-user-plus"></i> Add
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>