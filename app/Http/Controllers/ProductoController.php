<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
use Illuminate\Database\QueryException;
/**
 * Controlador para la gestión de productos.
 * Este controlador maneja la creación, actualización, listado y eliminación de productos.
 */
class ProductoController extends Controller
{
    // Variable protegida para manejar Hashids, utilizada para codificar/decodificar los IDs de los productos.
    protected $hashids;
    /**
     * Constructor del controlador.
     * Inicializa Hashids con una salida única y una longitud mínima de hash de 10 caracteres.
     * Esto permite que los IDs de los productos sean codificados antes de ser enviados al frontend.
     */
    public function __construct()
    {
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Inicia la consulta de productos
        $query = Producto::query();
        // Si se incluye un término de búsqueda, se filtra por nombre o ID del producto
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id_producto', 'LIKE', "%{$searchTerm}%");
        }
        // Se obtienen los productos paginados (10 por página)
        $productos = $query->paginate(10);

        // Codifica los IDs de los productos antes de enviarlos a la vista
        $productos->getCollection()->transform(function ($producto) {
            $producto->hashed_id = $this->hashids->encode($producto->id_producto);
            return $producto;
        });
        // Retorna la vista 'producto.index' con los productos codificados
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
        //Se valida que el campo cumpla con los requsitos
        $request->validate([
            'nombre' => 'required|string|max:75|unique:producto,nombre',
        ], [
            'nombre.unique' => 'El nombre del producto ya existe. Por favor, elige otro nombre.',
        ]);
        //Se establece la fecha y hora de Guatemala para los campos dateTime
        $currentDateTime = Carbon::now('America/Guatemala');

        $producto = DB::table('producto')->insertGetId([
            'nombre' => $request->nombre,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);
        //Se retorna la vista Index y se cargan todos los productos.
        return redirect()->route('productos.index')->with('success', '✅ Producto registrado exitosamente.');
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
        //Se decodifica el ID encriptado
        $id_producto = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_producto) {
            abort(404);
        }
        //Se busca el ID en la tabla para validar
        $producto = Producto::findOrFail($id_producto);
        $producto->hashed_id = $hashedId; // Usamos el hashed_id directamente nuevamente
        return view('productos.edit', compact('producto'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hashedId)
    {
        //Se decodifica el ID encriptado
        $id_producto = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_producto) {
            abort(404);
        }
        $producto = Producto::findOrFail($id_producto);
        $request->validate([
            'nombre' => 'required|string|max:75|unique:producto,nombre,' . $producto->id_producto . ',id_producto',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 75 caracteres.',
            'nombre.unique' => 'El nombre del producto ya existe. Por favor, elige otro nombre.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $producto->nombre = $request->input('nombre');
        $producto->updated_at = $currentDateTime;
        $producto->save();

        return redirect()->route('productos.index')->with('success', '✅ Producto actualizado correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hashedId)
    {
        // Se decodifica el ID encriptado
        $id = $this->hashids->decode($hashedId)[0] ?? null;

        if (!$id) {
            abort(404);
        }

        $producto = Producto::findOrFail($id);

        try {
            // Intentar eliminar el producto
            $producto->delete();

            return redirect()->route('productos.index')->with('success', '✅ ¡Eliminado! El producto se ha borrado correctamente.');
        } catch (QueryException $e) {
            // Capturar el error específico de clave foránea
            if ($e->getCode() == "23000") {
                return redirect()->route('productos.index')->with('error', '❌ Operación no permitida. El producto está vinculado a otros datos.');
            }

            // Capturar otros tipos de errores
            return redirect()->route('productos.index')->with('error', '⚠️ ¡Ups! Algo salió mal. Intenta nuevamente más tarde.');
        }
    }
}
