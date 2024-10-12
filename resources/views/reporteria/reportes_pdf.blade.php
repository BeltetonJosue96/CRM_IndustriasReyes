<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #777;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="{{ public_path('images/circular.png') }}" alt="Logo Empresa" style="width: 100px; height: auto;">
    <h2>Reporte de Ventas</h2>
    <p>Fecha de Generación: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    @if($id_cliente)
        <p><strong>Cliente:</strong> {{ $cliente->nombre }} {{ $cliente->apellidos }}</p>
        <p><strong>Empresa:</strong> {{ $empresa ? $empresa->nombre : 'N/A' }}</p>
        <p><strong>Departamento:</strong> {{ $departamento->nombre }}</p>
    @elseif($id_empresa)
        <p><strong>Empresa:</strong> {{ $empresa->nombre }}</p>
    @endif
    @if($fecha_inicio && $fecha_fin)
        <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</p>
    @elseif($fecha_inicio)
        <p><strong>Desde:</strong> {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }}</p>
    @elseif($fecha_fin)
        <p><strong>Hasta:</strong> {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</p>
    @endif
</div>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Bien o Servicio</th>
        <th>Plan de Mantenimiento</th>
        <th>Costo (Q)</th>
    </tr>
    </thead>
    <tbody>
    @php
        $iterator = 1;
    @endphp
    @foreach($detalles as $detalle)
        <tr>
            <td>{{ $iterator++ }}</td>
            <td>
                {{ $detalle->modelo->codigo }} -
                {{ $detalle->modelo->linea->nombre }} -
                {{ $detalle->modelo->linea->producto->nombre }}
            </td>
            <td>{{ $detalle->planManto->nombre }}</td>
            <td>{{ number_format($detalle->costo, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold;">Total:</td>
        <td style="font-weight: bold;">Q {{ number_format($total, 2) }}</td>
    </tr>
    </tfoot>
</table>
</body>
</html>
