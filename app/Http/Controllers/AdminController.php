<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function dashboard()
    {
        $recentAttendances = Attendance::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('recentAttendances'));
    }

    public function users()
    {
        $all_users = User::all();
        return view('admin.users.index', compact('all_users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required|confirmed|min:4',
            'role' => 'required|in:admin,hr,employee',
        ]);

        try {
            $uniqueKey = Str::uuid();
            
            User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'key' => $uniqueKey,
            ]);

            return redirect()->route('admin.users')->with('success', 'User added successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone_number' => 'required',
        ]);

        try {
            User::where('id', $id)->update([
                'name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);

            return redirect()->route('admin.users')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            User::destroy($id);
            return redirect()->route('admin.users')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}