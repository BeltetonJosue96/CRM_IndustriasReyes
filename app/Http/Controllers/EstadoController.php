<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class EstadoController extends Controller
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
        $query = Estado::query();
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('estado', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id_estado', 'LIKE', "%{$searchTerm}%");
        }
        $estados = $query->paginate(10);

        $estados->getCollection()->transform(function ($estado) {
            $estado->hashed_id = $this->hashids->encode($estado->id_estado);
            return $estado;
        });
        return view('estado.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'estado' => 'required|string|max:45|unique:estado',
        ]);
        $request->validate([
            'estado' => 'required|string|max:45|unique:estado,estado',
        ], [
            'estado.unique' => 'El tipo de estado ya existe. Por favor, elige otro tipo de estado.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $estado = DB::table('estado')->insertGetId([
            'estado' => $request->estado,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);
        return redirect()->route('estados.index')
            ->with('success', 'Estado creado exitosamente.');
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
        $estado = Estado::findOrFail($id);
        return view('estados.show', compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($hashedId)
    {
        $id_estado = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_estado) {
            abort(404);
        }
        $estado = Estado::findOrFail($id_estado);
        $estado->hashed_id = $hashedId;
        return view('estado.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hashedId)
    {
        $id_estado = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_estado) {
            abort(404);
        }
        $estado = Estado::findOrFail($id_estado);
        $request->validate([
            'estado' => 'required|string|max:45|unique:estado,estado,' . $estado->id_estado . ',id_estado',
        ], [
            'estado.unique' => 'El tipo de estado ya existe. Por favor, elige otro tipo de estado.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $estado->estado = $request->input('estado');
        $estado->updated_at = $currentDateTime;
        $estado->save();

        return redirect()->route('estados.index')
            ->with('success', 'Estado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hashedId)
    {
        $id = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id) {
            abort(404);
        }
        $estado = Estado::findOrFail($id);
        $estado->delete();

        return redirect()->route('estados.index')
            ->with('success', 'Estado eliminado exitosamente.');
    }
}
