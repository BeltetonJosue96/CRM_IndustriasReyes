<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

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
        $Productos = DB::table('producto')->orderBy('id_producto', 'asc')->get();

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
            'nombre' => 'required|string|max:100|unique:linea',
            'id_producto' => 'required|exists:producto,id_producto',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $linea = new Linea([
            'nombre' => $request->nombre,
            'id_producto' =>$request->id_producto,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ]);
        $linea->save();
        return redirect()->route('lineas.index')->with('success', 'Linea registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Linea $linea)
    {
        // Muestra los detalles de una línea específica
        return view('linea.show', compact('linea'));
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

        return redirect()->route('lineas.index');
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
        $linea->delete();

        return redirect()->route('lineas.index');
    }
}
