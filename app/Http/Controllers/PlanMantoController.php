<?php

namespace App\Http\Controllers;

use App\Models\PlanManto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class PlanMantoController extends Controller
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

        $query = PlanManto::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id_plan_manto', 'LIKE', "%{$searchTerm}%");
        }
        $planes = $query->paginate(10);

        $planes->getCollection()->transform(function ($plan) {
            $plan->hashed_id = $this->hashids->encode($plan->id_plan_manto);
            return $plan;
        });
        // Retorna la vista 'producto.index' con los productos codificados
        return view('plan_manto.index', compact('planes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**public function create()
    {
        return view('plan_manto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:25|unique:plan_manto',
            'descripcion' => 'required|string|max:45|unique:plan_manto',
            'frecuencia_mes' => 'required|integer|min:1',
        ]);

        $currentDateTime = Carbon::now('America/Guatemala');

        $planes = DB::table('plan_manto')->insertGetId([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'frecuencia_mes' => $request->frecuencia_mes,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);

        return redirect()->route('planes.index')->with('success', 'Plan de mantenimiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    /**public function show(PlanManto $planManto)
    {
        return view('plan_manto.show', compact('planManto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**public function edit($hashedId)
    {
        //Se decodifica el ID encriptado
        $id_plan_manto = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_plan_manto) {
            abort(404);
        }
        //Se busca el ID en la tabla para validar
        $planes = PlanManto::findOrFail($id_plan_manto);
        $planes->hashed_id = $hashedId; // Usamos el hashed_id directamente nuevamente
        return view('plan_manto.edit', compact('planes'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**public function update(Request $request, $hashedId)
    {
        $id_plan_manto = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_plan_manto) {
            abort(404);
        }
        $planManto = PlanManto::findOrFail($id_plan_manto);
        $request->validate([
            'nombre' => 'required|string|max:25|unique:plan_manto,nombre,' . $planManto->id_plan_manto . ',id_plan_manto',
            'descripcion' => 'required|string|max:45|unique:plan_manto,descripcion,' . $planManto->id_plan_manto . ',id_plan_manto',
            'frecuencia_mes' => 'required|integer|min:1',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $planManto->nombre = $request->input('nombre');
        $planManto->descripcion = $request->input('descripcion');
        $planManto->frecuencia_mes = $request->input('frecuencia_mes');
        $planManto->updated_at = $currentDateTime;
        $planManto->save();

        return redirect()->route('planes.index')->with('success', 'Plan de mantenimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**public function destroy($hashedId)
    {
        $id = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id) {
            abort(404);
        }
        $planManto = PlanManto::findOrFail($id);
        $planManto->delete();

        return redirect()->route('planes.index')->with('success', 'Plan de mantenimiento eliminado exitosamente.');
    }*/
}
