<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//login
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'comp');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
});

//home
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'start')->name('home');
});

//usuarios
Route::controller(UserController::class)->group(function () {
    Route::get('/usuarios', 'start')->name('users');
    Route::post('/usuarios/nuevo', 'add')->name('add_user');
    Route::get('/usuarios/borrar/{id}', 'delete')->name('delete_user');
});

//cambiar contraseña
Route::controller(ChangePasswordController::class)->group(function () {
    Route::get('/ChangePassword', 'start')->name('ChangePassword');
    Route::post('/ChangePassword/input', 'input')->name('ChangePassword_input');
});
