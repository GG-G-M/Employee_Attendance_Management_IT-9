<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/users',[UserController::class,'loadAllUsers']);
Route::get('/add/user',[UserController::class,'loadAddUserForm']);
Route::post('/add/user',[UserController::class,'addUser'])->name('addUser');

Route::get('/edit/{id}',[UserController::class,'loadEditForm']);
Route::post('/edit/user',[UserController::class,'editUser'])->name('editUser');

Route::get('/delete/{id}',[UserController::class,'deleteUser']);



Route::get('/register', function ()
{
    return view('register');
});

Route::get('/login', function () {
    return view('login'); // Show login page
})->name('login');
Route::post('/login', [UserController::class, 'loginUser'])->name('loginUser');

Route::get('/login-qr', [UserController::class, 'showQRCodeScanner']);
Route::post('/login-qr/scan', [UserController::class, 'scanQRCode'])->name('scan.qr');

// Use only one logout route (POST is more secure)
Route::post('/logout', [UserController::class, 'logoutUser'])->name('logoutUser');