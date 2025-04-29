<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VotationController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\OptionController;

use Illuminate\Support\Facades\Route;

// Ruta para la página principal que llama al método 'index' del VotationController
Route::get('/', [VotationController::class, 'index'])->name('home');

// Recurso completo para las votaciones (CRUD)
Route::resource('votations', VotationController::class);
Route::resource('votes', VoteController::class);
Route::resource('options', OptionController::class)->except(['show', 'index'])->middleware('auth');

Route::post('/votes/{id}/like', [VoteController::class, 'like'])->name('votes.like')->middleware('auth');
Route::post('/options/{option}/vote', [VoteController::class, 'likeOption'])->name('votes.like-option')->middleware('auth');

// Ruta para el dashboard (solo accesible si el usuario está autenticado)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para la gestión del perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Cargar las rutas de autenticación
require __DIR__.'/auth.php';
