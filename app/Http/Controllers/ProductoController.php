<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class ProductoController extends Controller
{
    protected $hashids;

    public function __construct()
    {
        // Inicializamos Hashids con una sal única y una longitud mínima de hash
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }

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

        // Codificamos los IDs antes de pasarlos a la vista
        $productos->getCollection()->transform(function ($producto) {
            $producto->hashed_id = $this->hashids->encode($producto->id_producto);
            return $producto;
        });

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
        $producto = DB::table('producto')->insertGetId([
            'nombre' => $request->nombre,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($hashedId)
    {
        $id = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id) {
            abort(404);
        }
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($hashedId)
    {
        $id_producto = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_producto) {
            abort(404);
        }
        $producto = Producto::findOrFail($id_producto);
        $producto->hashed_id = $hashedId; // Usamos el hashed_id directamente
        return view('productos.edit', compact('producto'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hashedId)
    {
        $id_producto = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_producto) {
            abort(404);
        }
        $producto = Producto::findOrFail($id_producto);
        $request->validate([
            'nombre' => 'required|string|max:75|unique:producto,nombre,' . $producto->id_producto . ',id_producto',
        ], [
            'nombre.unique' => 'El nombre del producto ya existe. Por favor, elige otro nombre.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $producto->nombre = $request->input('nombre');
        $producto->updated_at = $currentDateTime;
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hashedId)
    {
        $id = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id) {
            abort(404);
        }
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
