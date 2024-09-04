<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required | unique:empresas | max:75',
        ]);
        $empresa = new Empresa();
        $empresa->nombre = $request->nombre;
        $empresa->save();

        return redirect()->route('empresas.index')->with('success', 'Empresa registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        return view('empresas.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nombre' => 'required | unique:empresas '. $empresa->id_empresa . ' | max:75',
        ]);
        $empresa->nombre = $request->nombre;
        $empresa->save();
        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada correctamente');
    }
}
