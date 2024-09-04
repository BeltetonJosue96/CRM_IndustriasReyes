<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:145',
            'apellidos' => 'required|string|max:145',
            'identificacion' => 'required|string|max:25|unique:cliente',
            'telefono' => 'required|string|max:45',
            'id_empresa' => 'nullable|integer|exists:empresa,id_empresa',
            'cargo' => 'nullable|string|max:45',
            'direccion' => 'required|string|max:245',
            'referencia' => 'required|string|max:245',
            'municipio' => 'required|string|max:45',
            'id_departamento' => 'required|integer|exists:departamento,id_departamento',
        ]);

        $cliente = new Cliente([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'identificacion' => $request->identificacion,
            'telefono' => $request->telefono,
            'id_empresa' => $request->id_empresa,
            'cargo' => $request->cargo,
            'direccion' => $request->direccion,
            'referencia' => $request->referencia,
            'municipio' => $request->municipio,
            'id_departamento' => $request->id_departamento,
        ]);

        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:145',
            'apellidos' => 'required|string|max:145',
            'identificacion' => 'required|string|max:25|unique:cliente,identificacion,' . $cliente->id_cliente,
            'telefono' => 'required|string|max:45',
            'id_empresa' => 'nullable|integer|exists:empresa,id_empresa',
            'cargo' => 'nullable|string|max:45',
            'direccion' => 'required|string|max:245',
            'referencia' => 'required|string|max:245',
            'municipio' => 'required|string|max:45',
            'id_departamento' => 'required|integer|exists:departamento,id_departamento',
        ]);

        $cliente->update([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'identificacion' => $request->identificacion,
            'telefono' => $request->telefono,
            'id_empresa' => $request->id_empresa,
            'cargo' => $request->cargo,
            'direccion' => $request->direccion,
            'referencia' => $request->referencia,
            'municipio' => $request->municipio,
            'id_departamento' => $request->id_departamento,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
