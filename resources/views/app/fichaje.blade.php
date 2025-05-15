@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Registro de Horas Laborales</h2>

    <div class="card p-4">
        <form method="POST" action="{{ route('marcar') }}">
            @csrf
            <div class="d-grid gap-2">
                <button type="submit" name="accion" value="entrada" class="btn btn-success">Hora de Entrada</button>
                <button type="submit" name="accion" value="salida" class="btn btn-danger">Hora de Salida</button>

                <hr>

                <button type="submit" name="accion" value="descanso_inicio" class="btn btn-warning">Inicio Descanso</button>
                <button type="submit" name="accion" value="descanso_fin" class="btn btn-primary">Fin Descanso</button>

                <hr>

                <button type="submit" name="accion" value="comida_inicio" class="btn btn-secondary">Inicio Comida</button>
                <button type="submit" name="accion" value="comida_fin" class="btn btn-dark">Fin Comida</button>
            </div>
        </form>

    </div>

    {{-- Registro actual --}}
    <div class="card mt-4">

        <div class="card-header bg-info text-white">
            Registro de hoy
        </div>
        <div class="card-body">
            @if(isset($registro))
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Hora de entrada:</strong>
                    <span>{{ $registro->hora_entrada ?? 'No marcada' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Hora de salida:</strong>
                    <span>{{ $registro->hora_salida ?? 'No marcada' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Inicio descanso:</strong>
                    <span>{{ $registro->hora_inicio_descanso ?? 'No marcada' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Fin descanso:</strong>
                    <span>{{ $registro->hora_fin_descanso ?? 'No marcada' }}</span>
                </li>

                <!-- Nuevo bloque para comida -->
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Inicio comida:</strong>
                    <span>{{ $registro->hora_inicio_comida ?? 'No marcada' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Fin comida:</strong>
                    <span>{{ $registro->hora_fin_comida ?? 'No marcada' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Horas comida:</strong>
                    <span>{{ $registro->horas_comida ?? '-' }} h</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Sanción comida (1h máximo):</strong>
                    <span>{{ $registro->sancion_comida ?? '-' }} h</span>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <strong>Horas trabajadas:</strong>
                    <span>{{ $registro->horas_trabajadas ?? '-' }} h</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Horas descanso:</strong>
                    <span>{{ $registro->horas_descanso ?? '-' }} h</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Sanción horas (30 min máximo):</strong>
                    <span>{{ $registro->sancion_horas ?? '-' }} h</span>
                </li>
            </ul>

            @else
            <p class="text-muted">No hay registro aún para hoy.</p>
            @endif
        </div>

    </div>
</div>

<!-- Botón -->
<div class="mb-3 text-end">
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#miModal">
        <i class="fas fa-info-circle"></i> Información
    </button>
</div>


<!-- Modal -->
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="tituloModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="infoModalLabel"><i class="fas fa-exclamation-circle"></i> Información importante</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>⚠️ Cada botón de fichaje solo puede ser pulsado <strong>una vez al día</strong>. Asegúrate de no equivocarte.</p>
                <p>❗ Si cometes un error, por favor envía un correo a uno de los siguientes administradores:</p>
                <ul>
                    <li>aaronsitooLoayza@YKSO.com</li>
                    <li>jessyMaradiaga@YKSO.com</li>
                    <li>abrahamZavala@YKSO.com</li>
                    <li>recursos.humanos@YKSO.com</li>
                </ul>
                <p>📬 En el correo, indica claramente tu nombre de usuario, la fecha y el tipo de error cometido.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


@endsection