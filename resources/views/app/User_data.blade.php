@extends('layouts.app')

@section('title', 'ykso | Modificar empleados')

@section('content')
    <div class="container mt-4">
        <div class="col-md-10 mx-auto">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <h3 class="card-title">Información</h3>
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
                                <th class="text-center">Nómina</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $empleado->name }}</td>
                                <td>{{ $empleado->email }}</td>
                                <td>{{ $empleado->userData->birth_date ?? '-' }}</td>
                                <td>{{ $empleado->userData->address ?? '-' }}</td>
                                <td>{{ $empleado->userData->company_assigned ?? '-' }}</td>
                                <td>{{ $empleado->userData->emergency_contact ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#modal-edit-{{ $empleado->id }}">
                                        <i class="fa fa-download"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection