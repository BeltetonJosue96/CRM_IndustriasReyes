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
    <p>Fecha de Generación: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    <p>Generado por: {{ Auth::user()->name }}</p>
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
        <th style="text-align: center">#</th>
        <th style="text-align: center">Cliente</th>
        <th style="text-align: center">Fecha de Venta</th>
        <th style="text-align: center">No. Venta</th>
        <th style="text-align: center">Bien o Servicio</th>
        <th style="text-align: center">Plan de<br>Mantenimiento</th>
        <th style="text-align: center">Costo (Q)</th>
    </tr>
    </thead>
    <tbody>
    @php
        $iterator = 1;
    @endphp
    @foreach($detalles as $detalle)
        <tr>
            <td style="text-align: center">{{ $iterator++ }}</td>
            <td>
                {{ $detalle->venta->cliente->nombre }}<br>
                {{ $detalle->venta->cliente->apellidos }}
            </td>
            <td style="text-align: center">{{ \Carbon\Carbon::parse($detalle->venta->fecha_venta)->format('d/m/Y') }}</td>
            <td style="text-align: center">{{ $detalle->id_venta }} - {{ $detalle->venta->created_at->format('Y') }}</td>
            <td>
                {{ $detalle->modelo->codigo }}<br>
                {{ $detalle->modelo->linea->nombre }}<br>
                {{ $detalle->modelo->linea->producto->nombre }}
            </td>
            <td style="text-align: center">{{ $detalle->planManto->nombre }}</td>
            <td style="text-align: right">{{ number_format($detalle->costo, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6" style="text-align: right; font-weight: bold;">Total:</td>
        <td style="font-weight: bold;">Q {{ number_format($total, 2) }}</td>
    </tr>
    </tfoot>
</table>
</body>
</html>
