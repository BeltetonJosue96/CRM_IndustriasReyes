<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentaController extends Controller
{
    protected $hashids;
    public function __construct()
    {
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }
    public function index(Request $request)
    {
        $query = Venta::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;

            // Convierte el término de búsqueda en una fecha si tiene formato dd/mm/yyyy
            $dateSearch = null;
            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $searchTerm)) {
                try {
                    $dateSearch = \Carbon\Carbon::createFromFormat('d/m/Y', $searchTerm)->format('Y-m-d');
                } catch (\Exception $e) {
                    // Si no se puede convertir, dejar $dateSearch como null
                }
            }

            // Buscar por descripción, nombre, apellidos y fecha
            $query->where('descripcion', 'like', "%$searchTerm%")
                ->orWhereHas('cliente', function ($query) use ($searchTerm) {
                    $query->where('nombre', 'like', "%$searchTerm%")
                        ->orWhere('apellidos', 'like', "%$searchTerm%");
                })
                ->orWhere('id_venta', $searchTerm);

            // Si la búsqueda es una fecha válida, se realiza la búsqueda por fecha
            if ($dateSearch) {
                $query->orWhere('fecha_venta', $dateSearch);
            }
        }
        $ventas = $query->paginate(10);
        $ventas->getCollection()->transform(function ($venta) {
            $venta->hashed_id = $this->hashids->encode($venta->id_venta);
            return $venta;
        });
        return view('ventas.index', compact('ventas'));
    }
    public function create()
    {
        $Clientes = DB::table('cliente')
            ->leftJoin('empresa', 'cliente.id_empresa', '=', 'empresa.id_empresa')
            ->select('cliente.*', DB::raw('IFNULL(empresa.nombre, "Sin empresa") as nombre_empresa'))
            ->orderBy('cliente.id_cliente', 'ASC')
            ->get();

        return view('ventas.create', compact('Clientes'));
    }
    public function store(Request $request)
    {
        // Valida la solicitud
        $request->validate([
            'fecha_venta' => 'required|date', // Validar la fecha en formato d/m/Y
            'descripcion' => 'required|string|max:245',
            'id_cliente' => 'required|exists:cliente,id_cliente', // Verificar que el cliente exista
        ]);

        // Obtener la fecha y hora actual en la zona horaria de Guatemala
        $currentDateTime = Carbon::now('America/Guatemala');

        // Crear una nueva venta con los datos validados
        $venta = new Venta([
            'fecha_venta' => $request->fecha_venta,
            'descripcion' => $request->descripcion,
            'id_cliente' => $request->id_cliente,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ]);

        // Guardar la venta en la base de datos
        $venta->save();

        // Codificar el id_venta con Hashids
        $hashedId = $this->hashids->encode($venta->id_venta);

        // Redirigir al listado de detalle de ventas con el id_venta encriptado
        return redirect()->route('detalle_ventas.create', ['hashedId' => $hashedId]);
    }
    public function destroy($hashedId)
    {
        //Se decodifica el ID encriptado
        $id_venta = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_venta) {
            abort(404);
        }

        $venta = Venta::findOrFail($id_venta);
        $venta->delete();

        return redirect()->route('ventas.index');
    }
    public function edit($hashedId)
    {
        $id_venta = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_venta) {
            return redirect()->route('ventas.index')->withErrors('Venta no encontrada.');
        }
        // Buscar la venta por su ID
        $venta = Venta::findOrFail($id_venta);
        $venta->hashed_id = $hashedId;
        $clientes = DB::table('cliente')
            ->leftJoin('empresa', 'cliente.id_empresa', '=', 'empresa.id_empresa')
            ->select('cliente.*', DB::raw('IFNULL(empresa.nombre, "Sin empresa") as nombre_empresa'))
            ->orderBy('cliente.id_cliente', 'ASC')
            ->get();

        // Retornar la vista de edición con los datos de la venta
        return view('ventas.edit', compact('venta', 'clientes'));
    }
    public function update(Request $request, $hashedId)
    {
        $id_venta = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_venta) {
            return redirect()->route('ventas.index')->withErrors('Venta no encontrada.');
        }
        // Valida la solicitud
        $request->validate([
            'fecha_venta' => 'required|date', // Validar que sea una fecha válida
            'descripcion' => 'required|string|max:245',
            'id_cliente' => 'required|exists:cliente,id_cliente', // Verificar que el cliente exista
        ]);

        // Obtener la fecha y hora actual en la zona horaria de Guatemala
        $currentDateTime = Carbon::now('America/Guatemala');

        // Buscar la venta por su ID
        $venta = Venta::findOrFail($id_venta);

        // Actualizar los campos de la venta con los datos validados
        $venta->fecha_venta = $request->fecha_venta;
        $venta->descripcion = $request->descripcion;
        $venta->id_cliente = $request->id_cliente;
        $venta->updated_at = $currentDateTime;

        // Guardar los cambios en la base de datos
        $venta->save();

        // Redirigir al listado de ventas con un mensaje de éxito
        return redirect()->route('ventas.index')->with('success', '✅ Venta actualizada correctamente');
    }

}
