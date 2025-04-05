@extends('layouts.app')

@section('title', 'ykso | change password')

@section('content')
    <div class="container mt-4">
        <div class="col-md-6 mx-auto">
            <div class="card card-outline card-primary">

                <div class="card-header text-center">
                    <h3 class="card-title">Cambiar contraseña</h3>
                </div>

                <form method="POST" action="{{route('ChangePassword_input')}}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="password">Contraseña actual</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Nueva contraseña</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cambiar nueva contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
