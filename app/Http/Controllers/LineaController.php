<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Illuminate\Database\QueryException;

class LineaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $hashids;
    public function __construct()
    {
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }
    public function index(Request $request)
    {
        $query = Linea::query();
        // Si se incluye un término de búsqueda, se filtra por nombre o ID del producto
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id_linea', 'LIKE', "%{$searchTerm}%");
        }

        $lineas = $query->paginate(10);

        $lineas->getCollection()->transform(function ($linea) {
            $linea->hashed_id = $this->hashids->encode($linea->id_linea);
            return $linea;
        });
        return view('linea.index', compact('lineas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Productos = DB::table('producto')->orderBy('id_producto', 'ASC')->get();

        // Pasar los datos a la vista
        return view('linea.create', compact('Productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida la solicitud
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_producto' => 'required|exists:producto,id_producto',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'id_producto.required' => 'Debe seleccionar un producto.',
            'id_producto.exists' => 'El producto seleccionado no es válido.',
        ]);

        // Verificar si ya existe la línea con el mismo nombre y producto
        $existingLine = Linea::where('id_producto', $request->id_producto)
            ->where('nombre', $request->nombre)
            ->first();

        if ($existingLine) {
            // Manejo del error si la línea ya existe
            return redirect()->route('lineas.index')->with('error', '🚫 La línea ya existe para este producto');
        }

        // Si no existe, se crea la nueva línea
        $currentDateTime = Carbon::now('America/Guatemala');
        $linea = new Linea([
            'nombre' => $request->nombre,
            'id_producto' => $request->id_producto,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ]);
        $linea->save();

        return redirect()->route('lineas.index')->with('success', '✅ Línea registrada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($hashedId)
    {
        $id_linea = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_linea) {
            return redirect()->route('lineas.index')->withErrors('Línea no encontrada.');
        }

        $linea = Linea::findOrFail($id_linea);
        $linea->hashed_id = $hashedId;
        $Productos = DB::table('producto')->get();
        return view('linea.edit', compact('linea', 'Productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hashedId)
    {
        // Decodificar el hashed_id
        $id_linea = $this->hashids->decode($hashedId)[0] ?? null;

        if (!$id_linea) {
            abort(404);
        }

        $linea = Linea::findOrFail($id_linea);

        $request->validate([
            'nombre' => 'required|string|max:145',
            'id_producto' => 'required|integer|exists:producto,id_producto',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $linea->updated_at = $currentDateTime;

        $linea->update($request->all());

        return redirect()->route('lineas.index')->with('success', '✅ Línea actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hashedId)
    {
        $id_linea = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_linea) {
            abort(404);
        }

        $linea = Linea::findOrFail($id_linea);
        try {
            $linea->delete();
            return redirect()->route('lineas.index')->with('success', '✅ ¡Eliminado! La línea se ha borrado correctamente.');
        } catch (QueryException $e) {
            // Capturar el error específico de clave foránea
            if ($e->getCode() == "23000") {
                return redirect()->route('lineas.index')->with('error', '❌ Operación no permitida. La línea está vinculada a otros datos.');
            }
            // Capturar otros tipos de errores
            return redirect()->route('lineas.index')->with('error', '⚠️ ¡Ups! Algo salió mal. Intenta nuevamente más tarde.');
        }
    }
}
