<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Database\QueryException;
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

            // Si el término de búsqueda tiene el formato ID-año, tratamos de separar ambas partes
            if (preg_match('/^(\d+)-(\d{4})$/', $searchTerm, $matches)) {
                $hiddenId = (int)$matches[1] - 1000;  // Restamos 1000 para obtener el id_cliente original
                $year = $matches[2];

                // Buscamos por id_cliente y el año de creación
                $query->where('id_cliente', $hiddenId)
                    ->whereYear('created_at', $year);
            } else {
                // Búsqueda por nombre, apellidos o empresa
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('apellidos', 'LIKE', "%{$searchTerm}%");

                    if (strtolower($searchTerm) === 'sin empresa') {
                        $query->orWhereNull('id_empresa');
                    } else {
                        $query->orWhereHas('empresa', function ($query) use ($searchTerm) {
                            $query->where('nombre', 'LIKE', "%{$searchTerm}%");
                        });
                    }
                });
            }
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
            'telefono' => 'required|string|max:8',
            'id_empresa' => 'nullable|integer|exists:empresa,id_empresa',
            'cargo' => 'nullable|string|max:45',
            'direccion' => 'required|string|max:245',
            'referencia' => 'required|string|max:245',
            'municipio' => 'required|string|max:45',
            'id_departamento' => 'required|integer|exists:departamento,id_departamento',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 145 caracteres.',

            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.string' => 'El campo apellidos debe ser una cadena de texto.',
            'apellidos.max' => 'Los apellidos no pueden tener más de 145 caracteres.',

            'identificacion.required' => 'El campo identificación es obligatorio.',
            'identificacion.string' => 'El campo identificación debe ser una cadena de texto.',
            'identificacion.max' => 'La identificación no puede tener más de 25 caracteres.',
            'identificacion.unique' => 'La identificación ingresada ya existe. Por favor, ingrese una diferente.',

            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.string' => 'El campo teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no puede tener más de 8 digitos.',

            'id_empresa.integer' => 'El campo empresa debe ser un número entero.',
            'id_empresa.exists' => 'La empresa seleccionada no es válida.',

            'cargo.string' => 'El campo cargo debe ser una cadena de texto.',
            'cargo.max' => 'El cargo no puede tener más de 45 caracteres.',

            'direccion.required' => 'El campo dirección es obligatorio.',
            'direccion.string' => 'El campo dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 245 caracteres.',

            'referencia.required' => 'El campo referencia es obligatorio.',
            'referencia.string' => 'El campo referencia debe ser una cadena de texto.',
            'referencia.max' => 'La referencia no puede tener más de 245 caracteres.',

            'municipio.required' => 'El campo municipio es obligatorio.',
            'municipio.string' => 'El campo municipio debe ser una cadena de texto.',
            'municipio.max' => 'El municipio no puede tener más de 45 caracteres.',

            'id_departamento.required' => 'El campo departamento es obligatorio.',
            'id_departamento.integer' => 'El campo departamento debe ser un número entero.',
            'id_departamento.exists' => 'El departamento seleccionado no es válido.',
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

        return redirect()->route('clientes.index')->with('success', '✅ Cliente registrado exitosamente.');
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

        return redirect()->route('clientes.index')->with('success', '✅ Cliente actualizado exitosamente.');
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
        try {
            $cliente->delete();

            return redirect()->route('clientes.index')->with('success', '✅ ¡Eliminado! El cliente se ha borrado correctamente.');
        } catch (QueryException $e) {
            // Capturar el error específico de clave foránea
            if ($e->getCode() == "23000") {
                return redirect()->route('clientes.index')->with('error', '❌ Operación no permitida. El cliente está vinculado a otros datos.');
            }

            // Capturar otros tipos de errores
            return redirect()->route('clientes.index')->with('error', '⚠️ ¡Ups! Algo salió mal. Intenta nuevamente más tarde.');
        }

    }
}
