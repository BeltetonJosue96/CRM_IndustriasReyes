<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\DetalleVenta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        // Validación de los filtros
        $request->validate([
            'id_cliente' => 'nullable|exists:cliente,id_cliente',
            'id_empresa' => 'nullable|exists:empresa,id_empresa',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        // Obtener todos los clientes y empresas para los selects
        $clientes = Cliente::all();
        $empresas = Empresa::all();

        // Obtener los parámetros de filtro
        $id_cliente = $request->input('id_cliente');
        $id_empresa = $request->input('id_empresa');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        // Inicializar la consulta de DetalleVenta con relaciones adicionales
        $detallesQuery = DetalleVenta::with(['venta.cliente', 'modelo.linea.producto', 'planManto']);

        // Filtrar por Cliente o Empresa
        if ($id_cliente) {
            // Filtrar por cliente
            $detallesQuery->whereHas('venta', function ($query) use ($id_cliente) {
                $query->where('id_cliente', $id_cliente);
            });
        } elseif ($id_empresa) {
            // Filtrar por empresa: obtener clientes de la empresa
            $detallesQuery->whereHas('venta.cliente', function ($query) use ($id_empresa) {
                $query->where('id_empresa', $id_empresa);
            });
        }

        // Filtrar por rango de fechas
        if ($fecha_inicio) {
            $detallesQuery->whereHas('venta', function ($query) use ($fecha_inicio) {
                $query->whereDate('fecha_venta', '>=', $fecha_inicio);
            });
        }

        if ($fecha_fin) {
            $detallesQuery->whereHas('venta', function ($query) use ($fecha_fin) {
                $query->whereDate('fecha_venta', '<=', $fecha_fin);
            });
        }

        // Ordenar por fecha de venta ascendente
        $detallesQuery->join('venta', 'detalle_venta.id_venta', '=', 'venta.id_venta')
            ->orderBy('venta.fecha_venta', 'asc')
            ->select('detalle_venta.*');

        // Obtener los detalles con paginación
        $detalles = $detallesQuery->paginate(20)->appends($request->all());

        // Calcular el total
        $total = $detallesQuery->sum('costo');

        return view('reporteria.reportes', compact('detalles', 'clientes', 'empresas', 'id_cliente', 'id_empresa', 'fecha_inicio', 'fecha_fin', 'total'));
    }

    public function exportarPdf(Request $request)
    {
        // Validación de los filtros
        $request->validate([
            'id_cliente' => 'nullable|exists:cliente,id_cliente',
            'id_empresa' => 'nullable|exists:empresa,id_empresa',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        // Obtener los parámetros de filtro
        $id_cliente = $request->input('id_cliente');
        $id_empresa = $request->input('id_empresa');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        // Inicializar la consulta de DetalleVenta con relaciones adicionales
        $detallesQuery = DetalleVenta::with(['venta.cliente', 'modelo.linea.producto', 'planManto']);

        // Filtrar por Cliente o Empresa
        if ($id_cliente) {
            // Filtrar por cliente
            $detallesQuery->whereHas('venta', function ($query) use ($id_cliente) {
                $query->where('id_cliente', $id_cliente);
            });
        } elseif ($id_empresa) {
            // Filtrar por empresa: obtener clientes de la empresa
            $detallesQuery->whereHas('venta.cliente', function ($query) use ($id_empresa) {
                $query->where('id_empresa', $id_empresa);
            });
        }

        // Filtrar por rango de fechas
        if ($fecha_inicio) {
            $detallesQuery->whereHas('venta', function ($query) use ($fecha_inicio) {
                $query->whereDate('fecha_venta', '>=', $fecha_inicio);
            });
        }

        if ($fecha_fin) {
            $detallesQuery->whereHas('venta', function ($query) use ($fecha_fin) {
                $query->whereDate('fecha_venta', '<=', $fecha_fin);
            });
        }

        // Ordenar por fecha de venta ascendente
        $detallesQuery->join('venta', 'detalle_venta.id_venta', '=', 'venta.id_venta')
            ->orderBy('venta.fecha_venta', 'asc')
            ->select('detalle_venta.*');

        // Obtener todos los detalles sin paginación
        $detalles = $detallesQuery->get();

        // Calcular el total
        $total = $detalles->sum('costo');

        // Obtener información del cliente o empresa para el encabezado del PDF
        if ($id_cliente) {
            $cliente = Cliente::with(['empresa', 'departamento'])->find($id_cliente);
            $empresa = $cliente->empresa;
            $departamento = $cliente->departamento;
        } elseif ($id_empresa) {
            $empresa = Empresa::find($id_empresa);
            $cliente = null;
            $departamento = null;
        } else {
            $cliente = null;
            $empresa = null;
            $departamento = null;
        }

        // Generar el PDF
        $pdf = Pdf::loadView('reporteria.reportes_pdf', compact('detalles', 'total', 'id_cliente', 'id_empresa', 'fecha_inicio', 'fecha_fin', 'cliente', 'empresa', 'departamento'));

        // Configurar opciones de tamaño y orientación
        $pdf->setPaper('A4', 'portrait');

        // Descargar el PDF
        return $pdf->download('reporte_ventas.pdf');
    }
}
