<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    // Mostrar formulario para añadir opciones a una votación
    public function create(Votation $votation): View
    {
        return view('options.create', compact('votation'));
    }

    // Guardar opción
    public function store(Request $request, Votation $votation)
    {
        $request->validate([
            'option_text' => 'required|string|max:255',
        ]);

        $votation->options()->create($request->only('option_text'));

        return Redirect::route('votations.edit', $votation)->with('success', 'Opción añadida correctamente.');
    }

    // Eliminar opción
    public function destroy(Option $option)
    {
        $option->delete();

        return back()->with('success', 'Opción eliminada correctamente.');
    }
}