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
        return view('votations.index', compact('votations'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('votations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'required|integer|exists:users,id',

        ]);
    
        // Añadir el user_id manualmente
        Votation::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => $request->user_id,
        ]);
    
        return redirect()->route('home')->with('success', 'Encuesta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Votation $votation)
    {
        return view('votations.show', compact('votation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Votation $votation)
    {
        return view('votations.edit', compact('votation' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Votation $votation): RedirectResponse
    {
        // Validar los datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        // Actualizar la encuesta
        $votation->update($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('votations.index')->with('success', 'Encuesta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Votation $votation)
    {
        // Eliminar la encuesta
        $votation->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('votations.index')->with('success', 'Encuesta eliminada exitosamente.');
    }
}