<?php

namespace App\Http\Controllers;

use App\Models\ControlDeManto;
use App\Models\Cliente;
use App\Models\Modelo;
use App\Models\PlanManto;
use Illuminate\Http\Request;

class ControlDeMantoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $controles = ControlDeManto::all();
        return view('control_manto.index', compact('controles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $modelos = Modelo::all();
        $planes = PlanManto::all();
        return view('control_manto.create', compact('clientes', 'modelos', 'planes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_modelo' => 'required|exists:modelos,id_modelo',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
            'fecha_venta' => 'nullable|date',
            'proximo_manto' => 'nullable|date',
            'contador' => 'required|integer',
        ]);

        ControlDeManto::create($request->all());

        return redirect()->route('control_manto.index')->with('success', 'Control de Mantenimiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ControlDeManto $controlDeManto)
    {
        return view('control_manto.show', compact('controlDeManto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ControlDeManto $controlDeManto)
    {
        $clientes = Cliente::all();
        $modelos = Modelo::all();
        $planes = PlanManto::all();
        return view('control_manto.edit', compact('controlDeManto', 'clientes', 'modelos', 'planes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ControlDeManto $controlDeManto)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_modelo' => 'required|exists:modelos,id_modelo',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
            'fecha_venta' => 'nullable|date',
            'proximo_manto' => 'nullable|date',
            'contador' => 'required|integer',
        ]);

        $controlDeManto->update($request->all());

        return redirect()->route('control_manto.index')->with('success', 'Control de Mantenimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ControlDeManto $controlDeManto)
    {
        $controlDeManto->delete();

        return redirect()->route('control_manto.index')->with('success', 'Control de Mantenimiento eliminado exitosamente.');
    }
}
