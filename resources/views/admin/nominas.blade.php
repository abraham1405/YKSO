@extends('layouts.app')

@section('title', 'Gestión de Nóminas')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Gestión de Nóminas</h2>

    <form method="GET" action="{{ route('admin.nominas') }}">
        <div class="form-group row">
            <label for="mes" class="col-sm-2 col-form-label">Seleccionar mes:</label>
            <div class="col-sm-4">
                <select name="mes" id="mes" class="form-control" onchange="this.form.submit()">
                    @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $i => $nombreMes)
                        <option value="{{ $i+1 }}" {{ request('mes') == $i+1 ? 'selected' : '' }}>
                            {{ $nombreMes }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    @if(count($nominas) > 0)
        <table class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Horas Normales</th>
                    <th>Horas Extras</th>
                    <th>Salario Bruto (€)</th>
                    <th>Salario Neto (€)</th>
                    <th>Acción</th> {{-- Nueva columna --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($nominas as $nomina)
                    <tr>
                        <td>{{ $nomina['empleado']->name }}</td>
                        <td>{{ number_format($nomina['horas_normales'], 2) }}</td>
                        <td>{{ number_format($nomina['horas_extras'], 2) }}</td>
                        <td>{{ number_format($nomina['salario_bruto'], 2) }}</td>
                        <td>{{ number_format($nomina['salario_neto'], 2) }}</td>
                        <td>
                            <a href="{{ route('nomina.pdf', ['id' => $nomina['empleado']->id, 'mes' => $mesSeleccionado]) }}"
                            class="btn btn-sm btn-primary">
                                PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted mt-4">No hay datos de nómina para el mes seleccionado.</p>
    @endif
</div>
@endsection
