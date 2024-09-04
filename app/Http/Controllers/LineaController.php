<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtiene todos los registros de la tabla 'linea'
        $lineas = Linea::all();
        return view('linea.index', compact('lineas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Muestra el formulario para crear una nueva línea
        return view('linea.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida la solicitud
        $request->validate([
            'nombre' => 'required|string|max:100|unique:linea',
            'id_producto' => 'required|exists:producto,id_producto',
        ]);

        // Crea una nueva línea con los datos proporcionados
        Linea::create($request->all());

        // Redirige a la lista de líneas con un mensaje de éxito
        return redirect()->route('linea.index')->with('success', 'Línea creada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Linea $linea
     * @return \Illuminate\Http\Response
     */
    public function show(Linea $linea)
    {
        // Muestra los detalles de una línea específica
        return view('linea.show', compact('linea'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Linea $linea
     * @return \Illuminate\Http\Response
     */
    public function edit(Linea $linea)
    {
        // Muestra el formulario para editar una línea existente
        return view('linea.edit', compact('linea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Linea $linea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Linea $linea)
    {
        // Valida la solicitud
        $request->validate([
            'nombre' => 'required|string|max:100|unique:linea,nombre,' . $linea->id_linea . ',id_linea',
            'id_producto' => 'required|exists:producto,id_producto',
        ]);

        // Actualiza los datos de la línea existente
        $linea->update($request->all());

        // Redirige a la lista de líneas con un mensaje de éxito
        return redirect()->route('linea.index')->with('success', 'Línea actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Linea $linea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Linea $linea)
    {
        // Elimina la línea especificada
        $linea->delete();

        // Redirige a la lista de líneas con un mensaje de éxito
        return redirect()->route('linea.index')->with('success', 'Línea eliminada con éxito.');
    }
}
