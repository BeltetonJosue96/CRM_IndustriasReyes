<?php

namespace App\Http\Controllers;

use App\Models\DetalleCheck;
use Illuminate\Http\Request;

class DetalleCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detallesCheck = DetalleCheck::all();
        return view('detalle_check.index', compact('detallesCheck'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('detalle_check.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_check' => 'required|exists:checklist,id_check',
            'id_control_manto' => 'required|exists:control_de_manto,id_control_manto',
            'fecha_manto' => 'nullable|date',
            'id_estado' => 'required|exists:estado,id_estado',
            'observaciones' => 'nullable|string|max:245',
        ]);

        $detalleCheck = DetalleCheck::create($validatedData);

        return redirect()->route('detalle_check.index')->with('success', 'Detalle de check creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetalleCheck $detalleCheck)
    {
        return view('detalle_check.show', compact('detalleCheck'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetalleCheck $detalleCheck)
    {
        return view('detalle_check.edit', compact('detalleCheck'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleCheck $detalleCheck)
    {
        $validatedData = $request->validate([
            'id_check' => 'required|exists:checklist,id_check',
            'id_control_manto' => 'required|exists:control_de_manto,id_control_manto',
            'fecha_manto' => 'nullable|date',
            'id_estado' => 'required|exists:estado,id_estado',
            'observaciones' => 'nullable|string|max:245',
        ]);

        $detalleCheck->update($validatedData);

        return redirect()->route('detalle_check.index')->with('success', 'Detalle de check actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetalleCheck $detalleCheck)
    {
        $detalleCheck->delete();

        return redirect()->route('detalle_check.index')->with('success', 'Detalle de check eliminado correctamente.');
    }
}
