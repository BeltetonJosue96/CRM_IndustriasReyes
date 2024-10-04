<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class ClienteController extends Controller
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
        $query = Cliente::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;

            $query->where(function ($query) use ($searchTerm) {
                $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('apellidos', 'LIKE', "%{$searchTerm}%");

                // Si el término de búsqueda es "Sin empresa", buscamos clientes con id_empresa = null
                if (strtolower($searchTerm) === 'sin empresa') {
                    $query->orWhereNull('id_empresa');
                } else {
                    // Si el término de búsqueda no es "Sin empresa", buscamos también en la tabla empresa
                    $query->orWhereHas('empresa', function ($query) use ($searchTerm) {
                        $query->where('nombre', 'LIKE', "%{$searchTerm}%");
                    });
                }
            });
        }

        $clientes = $query->paginate(10);

        $clientes->getCollection()->transform(function ($cliente) {
            $cliente->hashed_id = $this->hashids->encode($cliente->id_cliente);
            return $cliente;
        });

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Recuperar los departamentos y las empresas
        $Departamentos = DB::table('departamento')->orderBy('id_departamento', 'asc')->get();
        $Empresas = DB::table('empresa')->orderBy('id_empresa', 'asc')->get();

        // Pasar los datos a la vista
        return view('clientes.create', compact('Departamentos', 'Empresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:145',
            'apellidos' => 'required|string|max:145',
            'identificacion' => 'required|string|max:25|unique:cliente',
            'telefono' => 'required|string|max:45',
            'id_empresa' => 'nullable|integer|exists:empresa,id_empresa',
            'cargo' => 'nullable|string|max:45',
            'direccion' => 'required|string|max:245',
            'referencia' => 'required|string|max:245',
            'municipio' => 'required|string|max:45',
            'id_departamento' => 'required|integer|exists:departamento,id_departamento',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $cliente = new Cliente([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'identificacion' => $request->identificacion,
            'telefono' => $request->telefono,
            'id_empresa' => $request->id_empresa,
            'cargo' => $request->cargo,
            'direccion' => $request->direccion,
            'referencia' => $request->referencia,
            'municipio' => $request->municipio,
            'id_departamento' => $request->id_departamento,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ]);

        $cliente->save();

        return redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($hashedId)
    {
        // Decodificar el hashed_id
        $id_cliente = $this->hashids->decode($hashedId)[0] ?? null;

        if (!$id_cliente) {
            return redirect()->route('clientes.index')->withErrors('Cliente no encontrado.');
        }

        $cliente = Cliente::findOrFail($id_cliente);
        $cliente->hashed_id = $hashedId;
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($hashedId)
    {
        // Decodificar el hashed_id
        $id_cliente = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_cliente) {
            return redirect()->route('clientes.index')->withErrors('Cliente no encontrado.');
        }

        $cliente = Cliente::findOrFail($id_cliente);
        $cliente->hashed_id = $hashedId;
        $Departamentos = DB::table('departamento')->get();
        $Empresas = DB::table('empresa')->get();
        return view('clientes.edit', compact('cliente', 'Departamentos', 'Empresas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hashedId)
    {
        // Decodificar el hashed_id
        $id_cliente = $this->hashids->decode($hashedId)[0] ?? null;

        if (!$id_cliente) {
            abort(404);
        }

        $cliente = Cliente::findOrFail($id_cliente);

        $request->validate([
            'nombre' => 'required|string|max:145',
            'apellidos' => 'required|string|max:145',
            'identificacion' => 'required|string|max:25|unique:cliente,identificacion,' . $cliente->id_cliente .',id_cliente',
            'telefono' => 'required|string|max:45',
            'id_empresa' => 'nullable|integer|exists:empresa,id_empresa',
            'cargo' => 'nullable|string|max:45',
            'direccion' => 'required|string|max:245',
            'referencia' => 'required|string|max:245',
            'municipio' => 'required|string|max:45',
            'id_departamento' => 'required|integer|exists:departamento,id_departamento',
        ]);
        $currentDateTime = Carbon::now('America/Guatemala');
        $cliente->updated_at = $currentDateTime;

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hashedId)
    {
        //Se decodifica el ID encriptado
        $id_cliente = $this->hashids->decode($hashedId)[0] ?? null;
        if (!$id_cliente) {
            abort(404);
        }

        $cliente = Cliente::findOrFail($id_cliente);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
