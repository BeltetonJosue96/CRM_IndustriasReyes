<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use Illuminate\Http\Request;

class DetalleVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todos los registros de detalle_venta
        $detalleVentas = DetalleVenta::all();
        return view('detalle_venta.index', compact('detalleVentas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Muestra el formulario para crear un nuevo detalle_venta
        return view('detalle_venta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida la solicitud
        $request->validate([
            'costo' => 'required|numeric',
            'id_venta' => 'required|exists:venta,id_venta',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
            'id_modelo' => 'required|exists:modelo,id_modelo',
        ]);

        // Crea un nuevo registro de detalle_venta
        DetalleVenta::create($request->all());

        // Redirige a la lista de detalles con un mensaje de éxito
        return redirect()->route('detalle_venta.index')->with('success', 'Detalle de venta creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetalleVenta $detalleVenta)
    {
        // Muestra los detalles de un registro específico
        return view('detalle_venta.show', compact('detalleVenta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetalleVenta $detalleVenta)
    {
        // Muestra el formulario para editar un detalle_venta específico
        return view('detalle_venta.edit', compact('detalleVenta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleVenta $detalleVenta)
    {
        // Valida la solicitud
        $request->validate([
            'costo' => 'required|numeric',
            'id_venta' => 'required|exists:venta,id_venta',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
            'id_modelo' => 'required|exists:modelo,id_modelo',
        ]);

        // Actualiza el registro de detalle_venta
        $detalleVenta->update($request->all());

        // Redirige a la lista de detalles con un mensaje de éxito
        return redirect()->route('detalle_venta.index')->with('success', 'Detalle de venta actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetalleVenta $detalleVenta)
    {
        // Elimina el registro de detalle_venta
        $detalleVenta->delete();

        // Redirige a la lista de detalles con un mensaje de éxito
        return redirect()->route('detalle_venta.index')->with('success', 'Detalle de venta eliminado exitosamente.');
    }
}
