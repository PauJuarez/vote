<?php

namespace App\Http\Controllers;

use App\Models\Votation;
use Illuminate\Http\Request;

class VotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $votations = Votation::latest()->paginate(3);
        return view('votacions.index', compact('votations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('votacions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Crear la encuesta
        Votation::create($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('votacions.index')->with('success', 'Encuesta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Votation $votation)
    {
        return view('votacions.show', compact('votation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Votation $votation)
    {
        return view('votacions.edit', compact('votation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Votation $votation)
    {
        // Validar los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Actualizar la encuesta
        $votation->update($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('votacions.index')->with('success', 'Encuesta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Votation $votation)
    {
        // Eliminar la encuesta
        $votation->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('votacions.index')->with('success', 'Encuesta eliminada exitosamente.');
    }
}