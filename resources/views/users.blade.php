<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>IT-9</title>
</head>
<body>
    <div class="container">
        <div class="card"> 
            <div class="card-header">
                <h1>Hello, {{ Auth::user()->name }}</h1>
                <form action="{{ route('logoutUser') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>                
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
                        <th>QR</th>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Role</th>
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
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#qrModal{{$item->id}}">
                                            View QR Code
                                        </button>
                    
                                        <!-- Modal -->
                                        <div class="modal fade" id="qrModal{{$item->id}}" tabindex="-1" aria-labelledby="qrModalLabel{{$item->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">QR Code</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <!-- QR Code -->
                                                        <div id="qrCode{{$item->id}}">
                                                            {!! QrCode::size(150)->generate($item->key) !!}
                                                        </div>
                    
                                                        <!-- Print Button -->
                                                        <button class="btn btn-success mt-3" onclick="printQRCode('qrCode{{$item->id}}')">
                                                            Print QR Code
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->role}}</td>
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
                                <td colspan="8">No User Found!</td>
                            </tr>
                        @endif
                    </tbody>
                    <script>
                        function printQRCode(qrCodeId) {
                            var qrCodeElement = document.getElementById(qrCodeId).innerHTML;
                            var newWindow = window.open('', '_blank', 'width=300,height=300');
                            newWindow.document.write('<html><head><title>Print QR Code</title></head><body>');
                            newWindow.document.write(qrCodeElement);
                            newWindow.document.write('</body></html>');
                            newWindow.document.close();
                            newWindow.print();
                        }
                    </script>                    
                </table>
            </div>
        </div>
    </div>
</body>
</html>