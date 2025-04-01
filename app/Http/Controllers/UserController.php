<?php

namespace App\Http\Controllers;

use App\Models\User; //import this
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; //import this for password hashing
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str; //For QR key
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QR Code library


class UserController extends Controller
{
    //here create all crud logic
    public function loadAllUsers(){
        $all_users = User::all();
        return view('users',compact('all_users'));
    }

    public function loadAddUserForm(){
        return view('add_user');
    }

    public function addUser(Request $request)
    {
        // Perform form validation
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required|confirmed|min:4',
            'role' => 'required|in:admin,employee', // Ensure role is either 'admin' or 'employee'
        ]);
    
        try {
            // Generate a unique key
            $uniqueKey = Str::uuid();
    
            // Register user
            $new_user = new User;
            $new_user->name = $request->full_name;
            $new_user->email = $request->email;
            $new_user->phone_number = $request->phone_number;
            $new_user->password = Hash::make($request->password);
            $new_user->role = $request->role;
            $new_user->key = $uniqueKey;
            $new_user->save();
    
            return redirect('/users')->with('success', 'User Added Successfully');
        } catch (\Exception $e) {
            return redirect('/add/user')->with('fail', $e->getMessage());
        }
    }

    public function editUser(Request $request){
        // perform form validation here
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required',
        ]);
        try {
             // update user here
            $update_user = User::where('id',$request->user_id)->update([
                'name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);

            return redirect('/users')->with('success','User Updated Successfully');
        } catch (\Exception $e) {
            return redirect('/edit/user')->with('fail',$e->getMessage());
        }
    }

    public function loadEditForm($id){
        $user = User::find($id);

        return view('edit_user',compact('user'));
    }

    public function deleteUser($id){
        try {
            User::where('id',$id)->delete();
            return redirect('/users')->with('success','User Deleted successfully!');
        } catch (\Exception $e) {
            return redirect('/users')->with('fail',$e->getMessage());
            
        }
    }

// Login user
public function loginUser(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:4',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/users')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
    }

    return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
}

// Logout user
public function logoutUser(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login')->with('success', 'Logged out successfully!');
}

public function showQRCodeScanner()
{
    return view('login-qr');
}

// Handle QR code scan for login
public function scanQRCode(Request $request)
{
    $request->validate([
        'qr_code' => 'required|string'
    ]);

    $key = $request->input('qr_code');

    $user = User::where('key', $key)->first();

    if ($user) {
        Auth::login($user);
        $request->session()->regenerate(); // Regenerate session for security
        return redirect('/users')->with('success', 'Welcome back, ' . $user->name . '!');
    }

    return redirect()->back()
        ->withErrors(['qr_code' => 'Invalid QR Code!'])
        ->withInput();
}

}

