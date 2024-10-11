<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\DetalleCheck;
use App\Models\Estado;
use App\Models\PlanManto;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleCheckController extends Controller
{
    protected $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }

    public function create($hashedId)
    {
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            abort(404);
        }
        $check = Checklist::findOrFail($id_check);

        // Obtener los detalles del checklist con la información relacionada correcta y filtrada
        $detalles = DB::table('control_de_manto')
            ->join('cliente', 'control_de_manto.id_cliente', '=', 'cliente.id_cliente')
            ->join('empresa', 'cliente.id_empresa', '=', 'empresa.id_empresa')
            ->join('modelo', 'control_de_manto.id_modelo', '=', 'modelo.id_modelo')
            ->join('linea', 'modelo.id_linea', '=', 'linea.id_linea')
            ->join('producto', 'linea.id_producto', '=', 'producto.id_producto')
            ->join('plan_manto', 'control_de_manto.id_plan_manto', '=', 'plan_manto.id_plan_manto')
            ->where('control_de_manto.id_plan_manto', $check->id_plan_manto)
            ->where('control_de_manto.proximo_manto', '>=', $check->fecha_creacion)
            ->select(
                'control_de_manto.id_control_manto',
                'cliente.id_cliente',
                'cliente.nombre as cliente_nombre',
                'cliente.apellidos as cliente_apellidos',
                'empresa.nombre as nombre_empresa',
                'cliente.telefono',
                'modelo.codigo as modelo_codigo',
                'linea.nombre as linea_nombre',
                'producto.nombre as producto_nombre',
                'plan_manto.nombre as nombre_plan',
                'control_de_manto.contador',
                'control_de_manto.proximo_manto'
            )
            ->get();

        // Crear o actualizar registros en detalle_check
        foreach ($detalles as $detalle) {
            DetalleCheck::updateOrCreate(
                ['id_check' => $id_check, 'id_control_manto' => $detalle->id_control_manto],
                ['fecha_manto' => $detalle->proximo_manto, 'id_estado' => 1] // Asumiendo 1 como estado por defecto
            );
        }

        // Obtener los detalles actualizados para la vista
        $detallesCheck = DetalleCheck::where('id_check', $id_check)
            ->with(['controlDeManto.cliente.empresa', 'controlDeManto.modelo.linea.producto', 'controlDeManto.planManto', 'estado'])
            ->get();

        $estados = Estado::all();

        return view('detalle_check.create', compact('check', 'detallesCheck', 'estados', 'hashedId'));
    }

    public function store(Request $request, $hashedId)
    {
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            abort(404);
        }

        $fecha_manto = $request->input('fecha_manto', []);
        $estados = $request->input('estados', []);
        $observaciones = $request->input('observaciones', []);

        foreach ($estados as $id_detalle_check => $id_estado) {
            DetalleCheck::where('id_detalle_check', $id_detalle_check)
                ->update([
                    'fecha_manto' => $fecha_manto[$id_detalle_check] ?? null,
                    'id_estado' => $id_estado,
                    'observaciones' => $observaciones[$id_detalle_check] ?? null,
                ]);
        }

        return redirect()->route('checklist.index')->with('success', '✅ Detalles del checklist actualizados correctamente.');
    }

    public function edit($hashedId)
    {
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            abort(404);
        }
        $check = Checklist::findOrFail($id_check);

        // Obtener los detalles del checklist con la información relacionada correcta y filtrada
        $detalles = DB::table('control_de_manto')
            ->join('cliente', 'control_de_manto.id_cliente', '=', 'cliente.id_cliente')
            ->join('empresa', 'cliente.id_empresa', '=', 'empresa.id_empresa')
            ->join('modelo', 'control_de_manto.id_modelo', '=', 'modelo.id_modelo')
            ->join('linea', 'modelo.id_linea', '=', 'linea.id_linea')
            ->join('producto', 'linea.id_producto', '=', 'producto.id_producto')
            ->join('plan_manto', 'control_de_manto.id_plan_manto', '=', 'plan_manto.id_plan_manto')
            ->where('control_de_manto.id_plan_manto', $check->id_plan_manto)
            ->where('control_de_manto.proximo_manto', '>=', $check->fecha_creacion)
            ->select(
                'control_de_manto.id_control_manto',
                'cliente.id_cliente',
                'cliente.nombre as cliente_nombre',
                'cliente.apellidos as cliente_apellidos',
                'empresa.nombre as nombre_empresa',
                'cliente.telefono',
                'modelo.codigo as modelo_codigo',
                'linea.nombre as linea_nombre',
                'producto.nombre as producto_nombre',
                'plan_manto.nombre as nombre_plan',
                'control_de_manto.contador',
                'control_de_manto.proximo_manto'
            )
            ->get();

        // Obtener los detalles actualizados para la vista
        $detallesCheck = DetalleCheck::where('id_check', $id_check)
            ->with(['controlDeManto.cliente.empresa', 'controlDeManto.modelo.linea.producto', 'controlDeManto.planManto', 'estado'])
            ->get();

        $estados = Estado::all();

        return view('detalle_check.edit', compact('check', 'detallesCheck', 'estados', 'hashedId'));
    }

    public function update(Request $request, $hashedId)
    {
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            abort(404);
        }

        // Validar los datos de entrada
        $validated = $request->validate([
            'fecha_manto.*' => 'date',
            'estado.*' => 'required|exists:estados,id',
            'observaciones.*' => 'nullable|string',
        ]);

        $fecha_manto = $request->input('fecha_manto', []);
        $estados = $request->input('estados', []);
        $observaciones = $request->input('observaciones', []);

        foreach ($estados as $id_detalle_check => $id_estado) {
            DetalleCheck::where('id_detalle_check', $id_detalle_check)
                ->update([
                    'fecha_manto' => $fecha_manto[$id_detalle_check] ?? null,
                    'id_estado' => $id_estado,
                    'observaciones' => $observaciones[$id_detalle_check] ?? null,
                ]);
        }

        return redirect()->route('checklist.index')->with('success', '✅ Detalles del checklist actualizados correctamente.');
    }
}
