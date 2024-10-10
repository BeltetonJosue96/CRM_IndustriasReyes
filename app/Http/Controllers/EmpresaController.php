<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class EmpresaController extends Controller
{
    protected $hashids;
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }
    public function index(Request $request)
    {
        // Inicia la consulta de productos
        $query = Empresa::query();
        // Si se incluye un término de búsqueda, se filtra por nombre o ID del producto
        if ($request->has('search')) {
            $searchTerm = $request->search;

            // Verificamos si el término de búsqueda tiene el formato (Ej. 5001-2024)
            if (preg_match('/^(\d+)-(\d{4})$/', $searchTerm, $matches)) {
                $hiddenId = (int)$matches[1] - 5000;  // Restamos 5000 para obtener el id_empresa original
                $year = $matches[2];

                // Buscamos por id_empresa y el año de creación
                $query->where('id_empresa', $hiddenId)
                    ->whereYear('created_at', $year);
            } else {
                // Búsqueda por nombre o id_empresa sin el formato modificado
                $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('id_empresa', 'LIKE', "%{$searchTerm}%");
            }
        }
        // Se obtienen los productos paginados (10 por página)
        $empresas = $query->paginate(10);

        // Codifica los IDs de los productos antes de enviarlos a la vista
        $empresas->getCollection()->transform(function ($empresa) {
            $empresa->hashed_id = $this->hashids->encode($empresa->id_empresa);
            return $empresa;
        });
        // Retorna la vista 'producto.index' con los productos codificados
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
        //Se valida que el campo cumpla con los requsitos
        $request->validate([
            'nombre' => 'required|string|max:75|unique:empresa,nombre',
        ], [
            'nombre.unique' => 'El nombre de la empresa ya existe. Por favor, elige otro nombre.',
        ]);
        //Se establece la fecha y hora de Guatemala para los campos dateTime
        $currentDateTime = Carbon::now('America/Guatemala');

        $producto = DB::table('empresa')->insertGetId([
            'nombre' => $request->nombre,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);
        //Se retorna la vista Index y se cargan todos los podructos.
        return redirect()->route('empresas.index')->with('success', '✅ Empresa registrada correctamente.');
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
    public function edit($hashedId)
    {
        //Se decodifica el ID encriptado
        $id_empresa = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_empresa) {
            abort(404);
        }
        //Se busca el ID en la tabla para validar
        $empresa = Empresa::findOrFail($id_empresa);
        $empresa->hashed_id = $hashedId; // Usamos el hashed_id directamente nuevamente
        return view('empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hashedId)
    {
        //Se decodifica el ID encriptado
        $id_empresa = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_empresa) {
            abort(404);
        }
        $empresa = Empresa::findOrFail($id_empresa);
        $request->validate([
            'nombre' => 'required|string|max:75|unique:empresa,nombre,' . $empresa->id_empresa . ',id_empresa',
        ], [
            'nombre.unique' => 'El nombre de la empresa ya existe. Por favor, elige otro nombre.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $empresa->nombre = $request->input('nombre');
        $empresa->updated_at = $currentDateTime;
        $empresa->save();

        return redirect()->route('empresas.index')->with('success', '✅ Empresa actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hashedId)
    {
        //Se decodifica el ID encriptado
        $id = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id) {
            abort(404);
        }
        $empresa = Empresa::findOrFail($id);
        try {
            $empresa->delete();
            return redirect()->route('empresas.index')->with('success', '✅ ¡Eliminada! La empresa se ha borrado correctamente.');
        } catch (QueryException $e) {
            // Capturar el error específico de clave foránea
            if ($e->getCode() == "23000") {
                return redirect()->route('empresas.index')->with('error', '❌ Operación no permitida. La empresa está vinculada a otros datos.');
            }

            // Capturar otros tipos de errores
            return redirect()->route('empresas.index')->with('error', '⚠️ ¡Ups! Algo salió mal. Intenta nuevamente más tarde.');
        }

    }
}
