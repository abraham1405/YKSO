@extends('layouts.app')

@section('title', 'Gestión de Nóminas')

@section('content')
<div class="container mt-4">
    @if($isAdmin)
    <h2 class="mb-4">Gestión de Nóminas</h2>
    @else
    <h2 class="mb-4">Mi nomina</h2>
    @endif

    <form method="GET" action="{{ route('admin.nominas') }}">
        <div class="form-group row">
            <label for="mes" class="col-sm-2 col-form-label">Seleccionar mes:</label>
            <div class="col-sm-4">
                <select name="mes" id="mes" class="form-control" onchange="this.form.submit()">
                    @foreach($meses as $i => $nombreMes)
                        <option value="{{ $i+1 }}" {{ $mesSeleccionado == $i+1 ? 'selected' : '' }}>
                            {{ $nombreMes }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    @if($isAdmin)
        {{-- Tabla para Admin --}}
        @if(count($nominas) > 0)
            <table class="table table-striped table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Horas Normales</th>
                        <th>Horas Extras</th>
                        <th>Salario Bruto (€)</th>
                        <th>Salario Neto (€)</th>
                        <th>Acción</th>
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
    @else
        {{-- Tabla para empleado normal --}}
        @if(count($nominas) > 0)
            <table class="table table-striped table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Horas Normales</th>
                        <th>Horas Extras</th>
                        <th>Salario Bruto (€)</th>
                        <th>Salario Neto (€)</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $nombreMesSeleccionado }}</td>
                        <td>{{ number_format($nominas[0]['horas_normales'], 2) }}</td>
                        <td>{{ number_format($nominas[0]['horas_extras'], 2) }}</td>
                        <td>{{ number_format($nominas[0]['salario_bruto'], 2) }}</td>
                        <td>{{ number_format($nominas[0]['salario_neto'], 2) }}</td>
                        <td>
                            <a href="{{ route('nomina.pdf', ['id' => $nominas[0]['empleado']->id, 'mes' => $mesSeleccionado]) }}"
                               class="btn btn-sm btn-primary">
                                Descargar PDF
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted mt-4">No hay datos de nómina para el mes seleccionado.</p>
        @endif
    @endif
</div>
@endsection