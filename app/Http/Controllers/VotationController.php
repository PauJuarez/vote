<?php

namespace App\Http\Controllers;

use App\Models\Votation;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::allows('access-admin')) {
            return view('votations.create');
        }
        abort(403, 'Unauthorized!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'options' => 'required|array|min:2|max:5',
            'options.*' => 'string|max:255',
        ]);
    
        // Añadir el user_id manualmente
        $votation = Votation::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'user_id' => Auth::id(), // <-- ¡Aquí va el id del usuario logueado!
        ]);
        
        // Crear las opciones de la votación
        foreach ($request->options as $optionName) {
            if (!empty($optionName)) {
                $votation->options()->create([
                    'option_text' => $optionName, // ✅ Ahora usas el nuevo nombre
                    'votation_id' => $votation->id,
                ]);
            }
        }

        return redirect()->route('votations.index')->with('success', 'Votación creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Votation $votation)
    {
        if (Gate::allows('access-admin')) {
            return view('votations.edit', compact('votation'));
        }
        abort(403, 'Unauthorized!');
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
            'options' => 'nullable|array|min:2|max:5', // Opciones son ahora opcionales
            'options.*' => 'string|max:255',
        ]);

        // Actualizar la votación
        $votation->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'user_id' => Auth::id(), // Asumiendo que el usuario está autenticado
        ]);

        // Eliminar las opciones actuales antes de añadir nuevas
        $votation->options()->delete();

        // Si existen opciones, crearlas nuevamente
        if ($request->has('options')) {
            foreach ($request->input('options') as $optionText) {
                if (!empty($optionText)) {
                    $votation->options()->create([
                        'option_text' => $optionText, // El texto de la opción
                    ]);
                }
            }
        }

        return redirect()->route('votations.index')->with('success', 'Votación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Votation $votation)
    {
        if (Gate::allows('access-admin')) {
            // Eliminar la encuesta
            $votation->delete();

            // Redirigir con mensaje de éxito
            return redirect()->route('votations.index')->with('success', 'Encuesta eliminada exitosamente.');
        }
        abort(403, 'Unauthorized!');
    }
}
