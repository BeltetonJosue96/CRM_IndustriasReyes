<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Modelo;
use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\PlanManto;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class DetalleVentaController extends Controller
{
    protected $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }
    public function create($hashedId)
    {
        $id_venta = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_venta) {
            abort(404);
        }

        $venta = Venta::findOrFail($id_venta);
        $modelos = DB::table('modelo')
            ->join('linea', 'modelo.id_linea', '=', 'linea.id_linea')
            ->join('producto', 'linea.id_producto', '=', 'producto.id_producto')
            ->select('modelo.id_modelo', 'modelo.codigo as modelo_codigo', 'linea.nombre as linea_nombre', 'producto.nombre as producto_nombre', 'modelo.descripcion')
            ->orderBy('modelo.id_modelo', 'ASC')
            ->get();

        $planes = PlanManto::orderBy('id_plan_manto', 'ASC')->get();

        // Obtener los detalles de venta para la venta y generar el `hashed_id`
        $detalles = DetalleVenta::where('id_venta', $id_venta)->get()->map(function($detalle) {
            $detalle->hashed_id = $this->hashids->encode($detalle->id_detalle); // Genera el `hashed_id`
            return $detalle;
        });

        return view('detalle_venta.create', compact('venta', 'modelos', 'planes', 'detalles', 'hashedId'));
    }

    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'id_modelo' => 'required|exists:modelo,id_modelo',
            'costo' => 'required|numeric|min:0',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
            'hashed_id_venta' => 'required',
        ]);

        // Decodificar el id de la venta usando Hashids
        $id_venta = $this->hashids->decode($request->hashed_id_venta)[0] ?? null;
        if (!$id_venta) {
            return response()->json(['success' => false, 'message' => 'Venta no encontrada'], 404);
        }

        // Crear un nuevo detalle de venta
        $detalle = new DetalleVenta();
        $detalle->id_venta = $id_venta;
        $detalle->id_modelo = $request->id_modelo;
        $detalle->costo = $request->costo;
        $detalle->id_plan_manto = $request->id_plan_manto;

        // Guardar el detalle
        if ($detalle->save()) {
            // Codificar el `id_detalle` con Hashids
            $hashedIdDetalle = $this->hashids->encode($detalle->id_detalle);

            $detalle->load('modelo', 'planManto');

            return response()->json([
                'success' => true,
                'detalle' => [
                    'id' => $detalle->id_detalle,
                    'hashed_id' => $hashedIdDetalle, // Enviar el `hashed_id` en la respuesta
                    'modelo' => [
                        'descripcion' => $detalle->modelo->codigo
                    ],
                    'costo' => $detalle->costo,
                    'plan_manto' => $detalle->planManto->nombre,
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'errors' => ['No se pudo agregar el detalle']], 500);
        }
    }
    public function edit($hashedId)
    {
        // Decodificar el hashed_id para obtener el id_venta
        $id_venta = $this->hashids->decode($hashedId)[0] ?? null;

        if (!$id_venta) {
            abort(404, 'Venta no encontrada');
        }

        // Obtener la venta asociada
        $venta = Venta::findOrFail($id_venta);

        // Obtener todos los detalles de la venta
        $detalles = DetalleVenta::where('id_venta', $id_venta)->get()->map(function ($detalle) {
            $detalle->hashed_id = $this->hashids->encode($detalle->id_detalle); // Generar hashed_id para cada detalle
            return $detalle;
        });

        // Obtener los modelos y planes de mantenimiento para poblar los selects
        $modelos = DB::table('modelo')
            ->join('linea', 'modelo.id_linea', '=', 'linea.id_linea')
            ->join('producto', 'linea.id_producto', '=', 'producto.id_producto')
            ->select('modelo.id_modelo', 'modelo.codigo as modelo_codigo', 'linea.nombre as linea_nombre', 'producto.nombre as producto_nombre', 'modelo.descripcion')
            ->orderBy('modelo.id_modelo', 'ASC')
            ->get();

        $planes = PlanManto::orderBy('id_plan_manto', 'ASC')->get();

        // Retornar la vista con los detalles cargados
        return view('detalle_venta.edit', compact('venta', 'detalles', 'modelos', 'planes', 'hashedId'))
            ->with('hashids', $this->hashids);
    }

    public function update(Request $request, $hashed_id)
    {
        // Decodificar el hashed_id para obtener el id_detalle
        $id_detalleArray = $this->hashids->decode($hashed_id);

        // Verificar si se ha decodificado correctamente
        if (empty($id_detalleArray)) {
            return redirect()->route('detalle_ventas.index')->with('error', 'Detalle no encontrado.');
        }

        $id_detalle = $id_detalleArray[0];

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'id_modelo' => 'required|exists:modelo,id_modelo',
            'costo' => 'required|numeric|min:0',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
        ]);

        // Buscar el detalle de venta usando el id_detalle
        $detalle = DetalleVenta::findOrFail($id_detalle);

        // Actualizar los valores
        $detalle->update([
            'id_modelo' => $validatedData['id_modelo'],
            'costo' => $validatedData['costo'],
            'id_plan_manto' => $validatedData['id_plan_manto'],
        ]);

        // Redirigir a la vista de edición de la venta asociada
        return redirect()->route('detalle_ventas.edit', $this->hashids->encode($detalle->id_venta))
            ->with('success', 'Detalle de venta actualizado correctamente');
    }

}
