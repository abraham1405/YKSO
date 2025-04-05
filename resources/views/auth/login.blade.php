@extends('layouts.login')

@section('title', 'ykso | login')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">

            <div class="card-header text-center">
                <b class="h1">YKSO</b>
            </div>

            <div class="card-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Contraseña" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>

                        <div class="col-8">
                            <p class="mt-2">
                                <a href="forgot-password.html" class="float-right">Olvidé la contraseña</a>
                            </p>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
