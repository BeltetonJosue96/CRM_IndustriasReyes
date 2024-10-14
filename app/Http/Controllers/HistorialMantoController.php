<?php

namespace App\Http\Controllers;

use App\Models\HistorialManto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialMantoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtén el valor del campo de búsqueda
        $search = $request->input('search');

        // Construye la consulta inicial con los joins necesarios
        $query = DB::table('historial_manto')
            ->join('estado', 'historial_manto.id_estado', '=', 'estado.id_estado')
            ->select('historial_manto.*', 'estado.estado as nombre_estado');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('historial_manto.id_historial_manto', 'like', "%{$search}%")
                    ->orWhere('historial_manto.id_detalle_check', 'like', "%{$search}%")
                    ->orWhere('historial_manto.id_control_manto', 'like', "%{$search}%")
                    ->orWhere('estado.estado', 'like', "%{$search}%")
                    ->orWhere('historial_manto.observaciones', 'like', "%{$search}%");

                // Convertir fecha de entrada a Y-m-d
                if (\Carbon\Carbon::hasFormat($search, 'd/m/Y')) {
                    $fecha = \Carbon\Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
                    $q->orWhere('historial_manto.fecha_programada', 'like', "%{$fecha}%");
                }
            });
        }

        // Paginar los resultados
        $historiales = $query->paginate(10);

        // Pasar los datos a la vista
        return view('historial_manto.index', compact('historiales'));
    }

}
