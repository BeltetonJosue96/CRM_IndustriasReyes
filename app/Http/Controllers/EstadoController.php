<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Estado::query();
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('estado', 'LIKE', "%{$searchTerm}%")
                ->orWhere('estado', 'LIKE', "%{$searchTerm}%");
        }
        $estados = $query->paginate(10);
        return view('estado.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estado.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'estado' => 'required|string|max:45|unique:estado',
        ]);

        Estado::create($request->all());

        return redirect()->route('estado.index')
            ->with('success', 'Estado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estado $estado)
    {
        return view('estado.show', compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estado $estado)
    {
        return view('estado.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estado $estado)
    {
        $request->validate([
            'estado' => 'required|string|max:45|unique:estado,estado,' . $estado->id_estado,
        ]);

        $estado->update($request->all());

        return redirect()->route('estado.index')
            ->with('success', 'Estado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estado $estado)
    {
        $estado->delete();

        return redirect()->route('estado.index')
            ->with('success', 'Estado eliminado exitosamente.');
    }
}
