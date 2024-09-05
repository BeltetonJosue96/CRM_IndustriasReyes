<?php

namespace App\Http\Controllers;

use App\Models\HistorialManto;
use Illuminate\Http\Request;

class HistorialMantoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historiales = HistorialManto::all();
        return view('historial_manto.index', compact('historiales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('historial_manto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_detalle_check' => 'required|exists:detalle_check,id_detalle_check',
            'id_control_manto' => 'required|exists:control_de_manto,id_control_manto',
            'id_estado' => 'required|exists:estado,id_estado',
            'fecha_programada' => 'nullable|date',
            'contador' => 'nullable|integer',
            'observaciones' => 'nullable|string|max:245',
        ]);

        $historialManto = new HistorialManto($request->all());
        $historialManto->save();

        return redirect()->route('historial_manto.index')->with('success', 'Historial de mantenimiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HistorialManto $historialManto)
    {
        return view('historial_manto.show', compact('historialManto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistorialManto $historialManto)
    {
        return view('historial_manto.edit', compact('historialManto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistorialManto $historialManto)
    {
        $request->validate([
            'id_detalle_check' => 'required|exists:detalle_check,id_detalle_check',
            'id_control_manto' => 'required|exists:control_de_manto,id_control_manto',
            'id_estado' => 'required|exists:estado,id_estado',
            'fecha_programada' => 'nullable|date',
            'contador' => 'nullable|integer',
            'observaciones' => 'nullable|string|max:245',
        ]);

        $historialManto->update($request->all());

        return redirect()->route('historial_manto.index')->with('success', 'Historial de mantenimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistorialManto $historialManto)
    {
        $historialManto->delete();
        return redirect()->route('historial_manto.index')->with('success', 'Historial de mantenimiento eliminado exitosamente.');
    }
}
