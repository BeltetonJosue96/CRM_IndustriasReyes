<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\PlanManto;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    protected $hashids;
    public function __construct()
    {
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }
    public function index(Request $request)
    {
        $query = Checklist::query();

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

            // Buscar por el formato (\d+)-(\d{4}) y ajustar el id y el año
            if (preg_match('/^(\d+)-(\d{4})$/', $searchTerm, $matches)) {
                $hiddenId = (int)$matches[1] - 8000;
                $year = $matches[2];
                $query->where('id_check', $hiddenId)
                    ->whereYear('created_at', $year);
            } else {
                // Buscar por nombre del plan de mantenimiento en lugar de id_plan_manto
                $query->whereHas('planManto', function ($query) use ($searchTerm) {
                    $query->where('nombre', 'like', "%$searchTerm%");
                });

                // Si la búsqueda es una fecha válida, se realiza la búsqueda por fecha
                if ($dateSearch) {
                    $query->orWhere('fecha_creacion', $dateSearch);
                }
            }
        }

        $checks = $query->paginate(10);
        $checks->getCollection()->transform(function ($check) {
            $check->hashed_id = $this->hashids->encode($check->id_check);
            return $check;
        });

        return view('checklist.index', compact('checks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $planes = PlanManto::where('id_plan_manto', '<', 5)
            ->orderBy('id_plan_manto', 'asc')
            ->get(['id_plan_manto', 'nombre']);

        // Retornar la vista de creación de checklist, pasando los planes de mantenimiento
        return view('checklist.create', compact('planes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'fecha_creacion' => 'required|date',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
        ]);

        // Crear un nuevo checklist con los datos validados
        $check = Checklist::create([
            'fecha_creacion' => $request->fecha_creacion,
            'id_plan_manto' => $request->id_plan_manto,
        ]);
        $hashedId = $this->hashids->encode($check->id_check);

        // Redirigir a la lista de checklists con un mensaje de éxito
        return redirect()->route('detallecheck.create',['hashedId' => $hashedId])->with('success', '✅ Checklist creado corectamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($hashedId)
    {
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            return redirect()->route('checklist.index')->withErrors('Checklist no encontrado.');
        }

        $check = Checklist::findOrFail($id_check);
        $check->hashed_id = $hashedId;
        $planes = PlanManto::where('id_plan_manto', '<', 5)
            ->orderBy('id_plan_manto', 'asc')
            ->get(['id_plan_manto', 'nombre']);

        // Retornar la vista de edición con los datos de la venta
        return view('checklist.edit', compact('check', 'planes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hashedId)
    {
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            return redirect()->route('checklist.index')->withErrors('Checklist no encontrado.');
        }
        $request->validate([
            'fecha_creacion' => 'required|date',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
        ]);

        // Obtener la fecha y hora actual en la zona horaria de Guatemala
        $currentDateTime = Carbon::now('America/Guatemala');

        // Buscar la venta por su ID
        $check = Checklist::findOrFail($id_check);

        $check->fecha_creacion = $request->fecha_creacion;
        $check->id_plan_manto = $request->id_plan_manto;
        $check->updated_at = $currentDateTime;

        // Guardar los cambios en la base de datos
        $check->save();

        // Redirigir al listado de ventas con un mensaje de éxito
        return redirect()->route('checklist.index')->with('success', '✅ Checklist actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hashedId)
    {
        //Se decodifica el ID encriptado
        $id_check = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_check) {
            abort(404);
        }

        $check = Checklist::findOrFail($id_check);
        $check->delete();

        return redirect()->route('checklist.index')->with('success', '✅ ¡Eliminado! El checklist se ha borrado correctamente.');
    }
}
