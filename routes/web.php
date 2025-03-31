<?php

use App\Http\Controllers\UserController; //import this
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