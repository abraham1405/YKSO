@extends('layouts.app')

@section('title', 'ykso | home')

@section('content')
    <div class="container mt-4">
        <div class="text-center">
            <img src="{{ asset('img/app/logo_sidebar.png') }}" alt="Foto de la empresa" class="img-fluid rounded shadow" style="max-height: 300px;">
        </div>

        <div class="mt-4 text-center">
            <h1 class="display-5">Bienvenidos a YKSO</h1>
            <p class="lead">
                Somos una empresa dedicada a la gestión eficiente de empleados. Proveemos soluciones digitales para
                controlar horarios, registrar asistencia y facilitar la administración del personal de tu empresa.
            </p>
        </div>
    </div>
@endsection
