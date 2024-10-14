<?php

namespace App\Http\Controllers;

use App\Models\ControlDeManto;
use App\Models\Cliente;
use App\Models\Modelo;
use App\Models\PlanManto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControlDeMantoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('control_de_manto')
            ->join('cliente', 'control_de_manto.id_cliente', '=', 'cliente.id_cliente')
            ->join('modelo', 'control_de_manto.id_modelo', '=', 'modelo.id_modelo')
            ->join('plan_manto', 'control_de_manto.id_plan_manto', '=', 'plan_manto.id_plan_manto')
            ->select(
                'control_de_manto.*',
                'cliente.nombre as nombre_cliente',
                'cliente.apellidos as apellidos_cliente',
                'modelo.codigo as nombre_modelo',
                'plan_manto.nombre as nombre_plan'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('control_de_manto.id_control_manto', 'like', "%{$search}%")
                    ->orWhere('cliente.nombre', 'like', "%{$search}%")
                    ->orWhere('cliente.apellidos', 'like', "%{$search}%")
                    ->orWhere('modelo.codigo', 'like', "%{$search}%")
                    ->orWhere('plan_manto.nombre', 'like', "%{$search}%")
                    ->orWhere('control_de_manto.contador', 'like', "%{$search}%");

                if (\Carbon\Carbon::hasFormat($search, 'd/m/Y')) {
                    $fecha = \Carbon\Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
                    $q->orWhere('control_de_manto.fecha_venta', 'like', "%{$fecha}%")
                        ->orWhere('control_de_manto.proximo_manto', 'like', "%{$fecha}%");
                }
            });
        }

        $controlMantos = $query->orderBy('control_de_manto.id_control_manto', 'asc')->paginate(10);

        return view('control_manto.index', compact('controlMantos'));
    }


}
