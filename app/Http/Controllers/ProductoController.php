<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::query();
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id_producto', 'LIKE', "%{$searchTerm}%");
        }
        $productos = $query->paginate(10);
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:75|unique:producto,nombre',
        ], [
            'nombre.unique' => 'El nombre del producto ya existe. Por favor, elige otro nombre.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        DB::table('producto')->insert([
            'nombre' => $request->nombre,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_producto)
    {
        $producto = Producto::findOrFail($id_producto);

        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:75|unique:producto,nombre',
        ], [
            'nombre.unique' => 'El nombre del producto ya existe. Por favor, elige otro nombre.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');

        $producto = Producto::findOrFail($id_producto);
        $producto->nombre = $request->input('nombre');
        $producto->updated_at = $currentDateTime;
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
