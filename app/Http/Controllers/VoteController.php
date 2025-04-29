<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Votation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

    }

    /**
     * Handle the "like" action for a specific Vote.
     */
    public function like($id): RedirectResponse
    {
        // Buscar la votación por su ID
        $votation = Votation::findOrFail($id);
    
        // Verificar si el usuario ya ha votado esta votación
        $existingVote = Vote::where('votation_id', $votation->id)
                            ->where('user_id', Auth::id())
                            ->first();
    
        if ($existingVote) {
            // Si ya votó, eliminar el voto
            $existingVote->delete();
            return back()->with('success', 'Tu voto ha sido eliminado.');
        }
    
        // Crear un nuevo voto positivo
        Vote::create([
            'votation_id' => $votation->id,
            'user_id' => Auth::id(),
        ]);
    
        return back()->with('success', '¡Gracias por tu voto!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vote $vote): RedirectResponse
    {
        $vote->delete();
        return back()->with('success', 'Voto eliminado correctamente.');
    }
}