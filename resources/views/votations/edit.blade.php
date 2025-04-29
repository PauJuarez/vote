@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-12">
        <div>
            <h2>Editar Tarea</h2>
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <strong>Por las chancas de mi madre!</strong> Algo fue mal..<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
ooooooooooooooooooo{{ $votation->id }}
<form action="{{ route('votations.store') }}" method="POST">
    @csrf

    <!-- Título -->
    <div class="mb-3">
        <label for="title" class="form-label">Título:</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Ej: ¿Cuál es tu color favorito?" required>
    </div>

    <!-- Descripción -->
    <div class="mb-3">
        <label for="description" class="form-label">Descripción:</label>
        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Describe la votación..."></textarea>
    </div>

    <!-- Fechas -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label">Fecha de Inicio:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label">Fecha de Fin:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
    </div>

    <!-- Opciones dinámicas -->
    <div id="options-container">
        <label class="form-label">Opciones:</label>

        <!-- Primera opción (obligatoria) -->
        <div class="input-group mb-2">
            <input type="text" name="options[]" class="form-control" placeholder="Opción 1" required>
            <button type="button" class="btn btn-success add-option">+</button>
        </div>

        <!-- Más opciones se añadirán aquí mediante JS -->
    </div>

    <!-- Botón submit -->
    <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary btn-lg">Crear Votación</button>
    </div>
</form>
</div>
@endsection