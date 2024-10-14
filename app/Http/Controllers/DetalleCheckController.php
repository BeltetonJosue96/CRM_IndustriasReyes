<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ControlDeManto;
use App\Models\DetalleCheck;
use App\Models\Estado;
use App\Models\PlanManto;
use Carbon\Carbon;
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
        //Decodificación del ID encriptado
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            return redirect()->back()->with('error', '❌ Hubo un problema con el Identificador del Checklist. Por favor, reportalo al soporte técnico.');
        }

        //Obtención del Checklist
        $check = Checklist::findOrFail($id_check);

        // No se realiza ningún formateo ni validación de la fecha_creacion
        $fecha_creacion = $check->fecha_creacion;

        $detalles = ControlDeManto::with(['cliente.empresa', 'modelo.linea.producto', 'planManto'])
            ->where('id_plan_manto', $check->id_plan_manto)
            ->whereDate('proximo_manto', '>=', $fecha_creacion) // Utilizar la fecha directamente sin reformatear
            ->get();


        //Verificar si se recuperaron detalles
        if ($detalles->isEmpty()) {
            return redirect()->back()->with('error', '❌ Ups! No existen registros con la fecha y el plan de mantenimiento seleccionado. Por favor, inténtalo con otros parámetros.');
        }

        //Crear o actualizar registros en detalle_check
        foreach ($detalles as $detalle) {
            try {
                DetalleCheck::updateOrCreate(
                    [
                        'id_check' => $id_check,
                        'id_control_manto' => $detalle->id_control_manto
                    ],
                    [
                        'fecha_manto' => $detalle->proximo_manto,
                        'id_estado' => 1
                    ]
                );
            } catch (\Exception $e) {
                return redirect()->back()->with('error', '❌ Hubo un problema al generar los detalles del checklist. Por favor, inténtalo de nuevo.');
            }
        }

        //Obtener los detalles actualizados para la vista
        $detallesCheck = DetalleCheck::where('id_check', $id_check)
            ->with([
                'controlDeManto.cliente.empresa',
                'controlDeManto.modelo.linea.producto',
                'controlDeManto.planManto',
                'estado'
            ])
            ->get();

        //Obtener todos los estados disponibles
        $estados = Estado::all();

        //Retornar la vista con los datos
        return view('detalle_check.create', compact('check', 'detallesCheck', 'estados', 'hashedId'));
    }

    public function store(Request $request, $hashedId)
    {
        //Validación de los datos de la solicitud
        $validatedData = $request->validate([
            'fecha_manto.*'      => 'nullable|date',
            'estados.*'          => 'required|integer|exists:estado,id_estado',
            'observaciones.*'    => 'nullable|string|max:255',
        ]);

        //Decodificación del ID encriptado
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            return redirect()->back()->with('error', '❌ Hubo un problema al generar los detalles del checklist. Por favor, inténtalo de nuevo.');
        }

        //Obtener los datos validados
        $fecha_manto    = $validatedData['fecha_manto'] ?? [];
        $estados        = $validatedData['estados'] ?? [];
        $observaciones  = $validatedData['observaciones'] ?? [];

        try {
            //Iniciar una transacción para asegurar la atomicidad
            DB::transaction(function () use ($id_check, $fecha_manto, $estados, $observaciones) {
                foreach ($estados as $id_detalle_check => $id_estado) {
                    // Actualizar cada DetalleCheck correspondiente
                    DetalleCheck::where('id_detalle_check', $id_detalle_check)
                        ->update([
                            'fecha_manto'     => $fecha_manto[$id_detalle_check] ?? null,
                            'id_estado'       => $id_estado,
                            'observaciones'   => $observaciones[$id_detalle_check] ?? null,
                        ]);
                }
            });

            //Redireccionar con mensaje de éxito
            return redirect()->route('checklist.index')->with('success', '✅ Detalles del checklist actualizado correctamente.');

        } catch (\Exception $e) {
            //Redireccionar de vuelta con mensaje de error
            return redirect()->back()->with('error', '❌ Hubo un problema al actualizar los detalles del checklist. Por favor, inténtalo de nuevo.');
        }
    }

    public function edit($hashedId)
    {
        // Decodificación del ID encriptado
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            return redirect()->back()->with('error', '❌ Hubo un problema con el Identificador del Checklist. Por favor, reportalo al soporte técnico.');
        }

        // Obtención del Checklist
        $check = Checklist::findOrFail($id_check);

        // Obtener los detalles del checklist
        $detallesCheck = DetalleCheck::where('id_check', $id_check)
            ->with(['controlDeManto.cliente.empresa', 'controlDeManto.modelo.linea.producto', 'controlDeManto.planManto', 'estado'])
            ->get();

        // Obtener todos los estados disponibles
        $estados = Estado::all();

        // Retornar la vista de edición con los datos
        return view('detalle_check.edit', compact('check', 'detallesCheck', 'estados', 'hashedId'));
    }

    public function update(Request $request, $hashedId)
    {
        // Validación de los datos de la solicitud
        $validatedData = $request->validate([
            'fecha_manto.*'      => 'nullable|date',
            'estados.*'          => 'required|integer|exists:estado,id_estado',
            'observaciones.*'    => 'nullable|string|max:255',
        ]);

        // Decodificación del ID encriptado
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            return redirect()->back()->with('error', '❌ Hubo un problema al actualizar los detalles del checklist. Por favor, inténtalo de nuevo.');
        }

        // Obtener los datos validados
        $fecha_manto    = $validatedData['fecha_manto'] ?? [];
        $estados        = $validatedData['estados'] ?? [];
        $observaciones  = $validatedData['observaciones'] ?? [];

        try {
            // Iniciar una transacción para asegurar la atomicidad
            DB::transaction(function () use ($id_check, $fecha_manto, $estados, $observaciones) {
                foreach ($estados as $id_detalle_check => $id_estado) {
                    // Actualizar cada DetalleCheck correspondiente
                    DetalleCheck::where('id_detalle_check', $id_detalle_check)
                        ->update([
                            'fecha_manto'     => $fecha_manto[$id_detalle_check] ?? null,
                            'id_estado'       => $id_estado,
                            'observaciones'   => $observaciones[$id_detalle_check] ?? null,
                        ]);
                }
            });

            // Redireccionar con mensaje de éxito
            return redirect()->route('checklist.index')->with('success', '✅ Detalles del checklist actualizados correctamente.');

        } catch (\Exception $e) {
            // Redireccionar de vuelta con mensaje de error
            return redirect()->back()->with('error', '❌ Hubo un problema al actualizar los detalles del checklist. Por favor, inténtalo de nuevo.');
        }
    }

}
