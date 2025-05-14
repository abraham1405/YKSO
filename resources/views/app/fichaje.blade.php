@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Registro de Horas Laborales</h2>

    <div class="card p-4">
        <form method="POST" action="{{ route('marcar') }}">
            @csrf
            <div class="d-grid gap-2">
                <button type="submit" name="accion" value="entrada" class="btn btn-success" {{ session('entrada_marcada') ? 'disabled' : '' }}>Hora de Entrada</button>
                <button type="submit" name="accion" value="salida" class="btn btn-danger" {{ !session('entrada_marcada') || session('salida_marcada') ? 'disabled' : '' }}>Hora de Salida</button>

                <hr>

                <button type="submit" name="accion" value="descanso_inicio" class="btn btn-warning" {{ session('descanso_inicio') ? 'disabled' : '' }}>Inicio Descanso</button>
                <button type="submit" name="accion" value="descanso_fin" class="btn btn-primary" {{ !session('descanso_inicio') || session('descanso_fin') ? 'disabled' : '' }}>Fin Descanso</button>
            </div>
        </form>
    </div>
</div>
@endsection