<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklists = Checklist::all();
        return view('checklist.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('checklist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_creacion' => 'required|date',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
        ]);

        Checklist::create([
            'fecha_creacion' => $request->fecha_creacion,
            'id_plan_manto' => $request->id_plan_manto,
        ]);

        return redirect()->route('checklist.index')->with('success', 'Checklist created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Checklist $checklist)
    {
        return view('checklist.show', compact('checklist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        return view('checklist.edit', compact('checklist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklist $checklist)
    {
        $request->validate([
            'fecha_creacion' => 'required|date',
            'id_plan_manto' => 'required|exists:plan_manto,id_plan_manto',
        ]);

        $checklist->update([
            'fecha_creacion' => $request->fecha_creacion,
            'id_plan_manto' => $request->id_plan_manto,
        ]);

        return redirect()->route('checklist.index')->with('success', 'Checklist updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist)
    {
        $checklist->delete();

        return redirect()->route('checklist.index')->with('success', 'Checklist deleted successfully.');
    }
}
