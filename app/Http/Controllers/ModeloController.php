<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Linea;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class ModeloController extends Controller
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
        $query = Modelo::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('codigo', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id_modelo', 'LIKE', "%{$searchTerm}%");
        }

        $modelos = $query->paginate(10);

        $modelos->getCollection()->transform(function ($modelo) {
            $modelo->hashed_id = $this->hashids->encode($modelo->id_modelo);
            return $modelo;
        });
        return view('modelos.index', compact('modelos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Lineas = DB::table('linea')
            ->join('producto', 'linea.id_producto', '=', 'producto.id_producto')
            ->select('linea.id_linea', 'linea.nombre as linea_nombre', 'producto.nombre as producto_nombre')
            ->orderBy('linea.id_linea', 'ASC')
            ->get();
        return view('modelos.create', compact('Lineas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|max:45|unique:modelo',
            'descripcion' => 'required|max:45',
            'id_linea' => 'required|exists:linea,id_linea',
        ], [
            'codigo.required' => 'El campo código es obligatorio.',
            'codigo.max' => 'El código no puede tener más de 45 caracteres.',
            'codigo.unique' => 'Este código ya está registrado.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede tener más de 45 caracteres.',
            'id_linea.required' => 'Debe seleccionar una línea.',
            'id_linea.exists' => 'La línea seleccionada no es válida.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $modelo = new Modelo([
            'codigo' => $request->codigo,
            'descripcion' =>$request->descripcion,
            'id_linea' => $request->id_linea,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ]);
        $modelo->save();
        return redirect()->route('modelos.index');
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
    public function edit($hashedId)
    {
        $id_modelo = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_modelo) {
            return redirect()->route('modelos.index');
        }

        $modelo = Modelo::findOrFail($id_modelo);
        $Lineas = DB::table('linea')
            ->join('producto', 'linea.id_producto', '=', 'producto.id_producto')
            ->select('linea.id_linea', 'linea.nombre as linea_nombre', 'producto.nombre as producto_nombre')
            ->orderBy('linea.id_linea', 'ASC')
            ->get();
        $modelo->hashed_id = $hashedId;
        return view('modelos.edit', compact('modelo', 'Lineas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hashedId)
    {
        // Decodificar el hashed_id
        $id_modelo = $this->hashids->decode($hashedId)[0] ?? null;

        if (!$id_modelo) {
            abort(404);
        }

        $modelo = Modelo::findOrFail($id_modelo);
        $request->validate([
            'codigo' => 'required|max:45|unique:modelo,codigo,' . $modelo->id_modelo . ',id_modelo',
            'descripcion' => 'required|max:45',
            'id_linea' => 'required|integer|exists:linea,id_linea',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $modelo->updated_at = $currentDateTime;

        $modelo->update($request->all());

        return redirect()->route('modelos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hashedId)
    {
        $modelo = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$modelo) {
            abort(404);
        }

        $modelo = Modelo::findOrFail($modelo);
        $modelo->delete();
        return redirect()->route('modelos.index')->with('success', 'Modelo eliminado correctamente.');    }
}
