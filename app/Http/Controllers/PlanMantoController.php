<?php

namespace App\Http\Controllers;

use App\Models\PlanManto;
use Illuminate\Http\Request;

class PlanMantoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planes = PlanManto::all();
        return view('plan_manto.index', compact('planes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plan_manto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:25|unique:plan_manto',
            'descripcion' => 'required|string|max:45|unique:plan_manto',
            'frecuencia_mes' => 'required|integer|min:1',
        ]);

        PlanManto::create($validatedData);

        return redirect()->route('plan_manto.index')->with('success', 'Plan de mantenimiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanManto $planManto)
    {
        return view('plan_manto.show', compact('planManto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanManto $planManto)
    {
        return view('plan_manto.edit', compact('planManto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanManto $planManto)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:25|unique:plan_manto,nombre,' . $planManto->id_plan_manto . ',id_plan_manto',
            'descripcion' => 'required|string|max:45|unique:plan_manto,descripcion,' . $planManto->id_plan_manto . ',id_plan_manto',
            'frecuencia_mes' => 'required|integer|min:1',
        ]);

        $planManto->update($validatedData);

        return redirect()->route('plan_manto.index')->with('success', 'Plan de mantenimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanManto $planManto)
    {
        $planManto->delete();

        return redirect()->route('plan_manto.index')->with('success', 'Plan de mantenimiento eliminado exitosamente.');
    }
}
