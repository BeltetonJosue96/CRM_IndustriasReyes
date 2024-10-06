<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class DepartamentoController extends Controller
{
    protected $hashids;
    public function __construct(){
        $this->hashids = new Hashids(env('APP_KEY'), 10);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Departamento::query();
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id_departamento', 'LIKE', "%{$searchTerm}%");
        }
        $departamentos = $query->paginate(10);
        $departamentos->getCollection()->transform(function($departamento){
            $departamento->hashed_id = $this->hashids->encode($departamento->id_departamento);
            return $departamento;
        });
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**public function create()
    {
        return view('departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:45|unique:departamento,nombre',
        ], [
            'nombre.unique' => 'El nombre del departamento ya existe. Por favor, elige otro nombre.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $departamento = DB::table("departamento")->insertGetId([
            'nombre' => $request->nombre,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);
        return redirect()->route('departamentos.index')->with('success', 'Departamento creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    /**public function show(Departamento $departamento)
    {
        return view('departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**public function edit($hashedId)
    {
        //Se decodifica el ID encriptado
        $id_departamento = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_departamento) {
            abort(404);
        }
        //Se busca el ID en la tabla para validar
        $departamento = Departamento::findOrFail($id_departamento);
        $departamento->hashed_id = $hashedId; // Usamos el hashed_id directamente nuevamente
        return view('departamentos.edit', compact('departamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**public function update(Request $request, $hashedId)
    {
        //Se decodifica el ID encriptado
        $id_departamento = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_departamento) {
            abort(404);
        }
        $departamento = Departamento::findOrFail($id_departamento);
        $request->validate([
            'nombre' => 'required|string|max:45|unique:departamento,nombre,' . $departamento->id_departamento . ',id_departamento',
        ], [
            'nombre.unique' => 'El nombre del departamento ya existe. Por favor, elige otro nombre.',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $departamento->nombre = $request->input('nombre');
        $departamento->updated_at = $currentDateTime;
        $departamento->save();

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**public function destroy($hashedId)
    {
        //Se decodifica el ID encriptado
        $id = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id) {
            abort(404);
        }
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();
        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado con éxito.');
    }*/
}
