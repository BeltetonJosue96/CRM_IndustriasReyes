<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Linea;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelos = Modelo::all();
        return view('modelos.index', compact('modelos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lineas = Linea::all();
        return view('modelos.create', compact('lineas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:modelos',
            'descripcion' => 'required',
            'id_linea' => 'required|exists:lineas,id_linea',
        ]);

        Modelo::create($request->all());

        return redirect()->route('modelos.index')->with('success', 'Modelo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modelo $modelo)
    {
        return view('modelos.show', compact('modelo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modelo $modelo)
    {
        $lineas = Linea::all();
        return view('modelos.edit', compact('modelo', 'lineas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modelo $modelo)
    {
        $request->validate([
            'codigo' => 'required|unique:modelos,codigo,' . $modelo->id_modelo,
            'descripcion' => 'required',
            'id_linea' => 'required|exists:lineas,id_linea',
        ]);

        $modelo->update($request->all());

        return redirect()->route('modelos.index')->with('success', 'Modelo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $modelo)
    {
        $modelo->delete();

        return redirect()->route('modelos.index')->with('success', 'Modelo eliminado exitosamente.');
    }
}
