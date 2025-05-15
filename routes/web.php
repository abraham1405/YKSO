<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\EmployeeTimeLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NominasController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MessageController;
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
    Route::get('/empleados/modificar', [UserController::class, 'modificarEmpleados'])->name('modificar_empleados');
    Route::post('/empleados/modificar/{id}', [UserController::class, 'actualizarEmpleado'])->name('actualizar_empleado');
});

// nóminas
Route::controller(NominasController::class)->group(function () {
    Route::get('/admin/nominas', 'index')->name('admin.nominas');
    Route::get('/nomina/pdf/{id}', [NominasController::class, 'generarPDF'])->name('nomina.pdf');
});

//cambiar contraseña

Route::controller(ChangePasswordController::class)->group(function () {
    Route::get('/ChangePassword', 'start')->name('ChangePassword');
    Route::post('/ChangePassword/input', 'input')->name('ChangePassword_input');
});

// Funciones mail

Route::controller(MailController::class)->group(function () {
    Route::get('/mailbox', [MailController::class, 'mailbox'])->name('mailbox');
    Route::post('/send-mail', [MailController::class, 'send'])->name('send_mail');
    Route::post('/mark-as-read/{id}', [MessageController::class, 'markAsRead'])->name('mark_as_read');
});

// Fichaje

Route::controller(EmployeeTimeLogController::class)->group(function () {
    Route::post('/fichar', 'marcar')->name('marcar');
    Route::get('/fichar', 'start')->name('fichar');
});