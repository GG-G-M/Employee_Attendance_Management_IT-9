<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Authentication Routes
Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'loginUser'])->name('loginUser');
Route::get('/login-qr', [UserController::class, 'showQRCodeScanner'])->name('login.qr');
Route::post('/qr/scan', [QrController::class, 'handleScan'])->name('qr.scan');
Route::post('/logout', [UserController::class, 'logoutUser'])->name('logoutUser');

// User Management Routes
Route::get('/users', [UserController::class, 'loadAllUsers']);
Route::get('/add/user', [UserController::class, 'loadAddUserForm']);
Route::post('/add/user', [UserController::class, 'addUser'])->name('addUser');
Route::get('/edit/{id}', [UserController::class, 'loadEditForm']);
Route::post('/edit/user', [UserController::class, 'editUser'])->name('editUser');
Route::get('/delete/{id}', [UserController::class, 'deleteUser']);

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/hr/dashboard', [HrController::class, 'dashboard'])->name('hr.dashboard');
    
    // Employee Profile
    Route::get('/employee/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
    
    // Attendance Routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
    
// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});
    
    // Admin/HR Protected Routes
    Route::middleware(['can:update,attendance'])->group(function () {
        Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])
            ->name('attendance.edit');
        Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
            ->name('attendance.update');
    });
});