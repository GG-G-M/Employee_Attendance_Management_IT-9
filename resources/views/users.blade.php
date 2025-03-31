<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>IT-9</title>
</head>
<body>
    <div class="container">
        <div class="card"> 
            <div class="card-header">
                USER
                <a>Go back</a>
                <a href="/add/user" class="btn btn-success btn-sn float-end">
                    Add User
                </a>
            @if (Session::has('success'))
                <span class="alert alert-success p-2">
                    {{Session::get('success')}}
                </span>
            @endif
            @if (Session::has('fail'))
                <span class="alert alert-danger p-2">
                    {{Session::get('fail')}}
                </span>
            @endif
            </div>
            <div class="card-body">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Created</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if (count($all_users) > 0)
                            @foreach($all_users as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone_number}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>{{$item->updated_at}}</td>
                                    <td>
                                        <a href="/edit/{{$item->id}}" class="btn btn-success btn-sm">Edit</a>
                                        <a href="/delete/{{$item->id}}" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>No User Found!</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>