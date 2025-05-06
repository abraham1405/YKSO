@extends('layouts.app')

@section('title', 'ykso | Modificar empleados')

@section('content')
<div class="container mt-4">
    <div class="col-md-10 mx-auto">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3 class="card-title">Modificar Información de Empleados</h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha Nacimiento</th>
                            <th>Dirección</th>
                            <th>Empresa Asignada</th>
                            <th>Contacto Emergencia</th>
                            <th>Fecha Ingreso</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empleados as $empleado)
                            <tr>
                                <td>{{ $empleado->name }}</td>
                                <td>{{ $empleado->email }}</td>
                                <td>{{ $empleado->userData->birth_date ?? '-' }}</td>
                                <td>{{ $empleado->userData->address ?? '-' }}</td>
                                <td>{{ $empleado->userData->company_assigned ?? '-' }}</td>
                                <td>{{ $empleado->userData->emergency_contact ?? '-' }}</td>
                                <td>{{ $empleado->userData->entry_date ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#modal-edit-{{ $empleado->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de edición -->
                            <div class="modal fade" id="modal-edit-{{ $empleado->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="modalLabel{{ $empleado->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="POST" action="{{ route('actualizar_empleado', $empleado->id) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar datos de {{ $empleado->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Fecha de nacimiento</label>
                                                    <input type="date" name="birth_date" class="form-control"
                                                        value="{{ $empleado->userData->birth_date ?? '' }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Dirección</label>
                                                    <input type="text" name="address" class="form-control"
                                                        value="{{ $empleado->userData->address ?? '' }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Empresa asignada</label>
                                                    <input type="text" name="company_assigned" class="form-control"
                                                        value="{{ $empleado->userData->company_assigned ?? '' }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Contacto de emergencia</label>
                                                    <input type="text" name="emergency_contact" class="form-control"
                                                        value="{{ $empleado->userData->emergency_contact ?? '' }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Guardar cambios</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection