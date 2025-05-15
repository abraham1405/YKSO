<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nómina - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .info, .section {
            margin-bottom: 20px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            background-color: #e9e9e9;
        }

        .firma {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            width: 100%;
        }

        .firma div {
            width: 45%;
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Recibo de Nómina</h2>

    <div class="info">
        <p><strong>Empleado:</strong> {{ $user->name }}</p>
        <p><strong>Periodo:</strong> {{ \Carbon\Carbon::create()->month($mes)->locale('es')->isoFormat('MMMM') }} de {{ $anio }}</p>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Importe (€)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Horas normales ({{ $datos['horas_normales'] }}h)</td>
                    <td>{{ number_format($datos['pago_horas_normales'], 2) }}</td>
                </tr>
                <tr>
                    <td>Horas extra ({{ $datos['horas_extras'] }}h)</td>
                    <td>{{ number_format($datos['pago_horas_extras'], 2) }}</td>
                </tr>
                <tr class="total">
                    <td>Total devengado (Salario bruto)</td>
                    <td>{{ number_format($datos['salario_bruto'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Deducción</th>
                    <th>Importe (€)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Seguridad Social</td>
                    <td>{{ number_format($datos['cotizacion_seguridad_social'], 2) }}</td>
                </tr>
                <tr>
                    <td>Desempleo</td>
                    <td>{{ number_format($datos['desempleo'], 2) }}</td>
                </tr>
                <tr>
                    <td>Formación Profesional</td>
                    <td>{{ number_format($datos['formacion_profesional'], 2) }}</td>
                </tr>
                <tr>
                    <td>IRPF</td>
                    <td>{{ number_format($datos['irpf'], 2) }}</td>
                </tr>
                <tr class="total">
                    <td>Total Deducciones</td>
                    <td>{{ number_format($datos['total_deducciones'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <table>
            <tr class="total">
                <td>Líquido a percibir (Salario neto)</td>
                <td>{{ number_format($datos['salario_neto'], 2) }} €</td>
            </tr>
        </table>
    </div>

    <table style="width: 100%; margin-top: 50px; font-size: 12px;">
        <tr>
            <td style="text-align: center; height: 100px; vertical-align: bottom;">
                ________________________<br>
                Firma del empleado
            </td>
            <td style="text-align: center; height: 100px; vertical-align: bottom;">
                ________________________<br>
                Firma de la empresa
            </td>
        </tr>
    </table>
</body>
</html>
