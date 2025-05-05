@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Crear Nueva Votación</h3>
                    <a href="{{ route('home') }}" class="btn btn-primary">Volver</a>
                </div>
                <div class="card-body">

                    <!-- Mensaje de error -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ups!</strong> Algo salió mal.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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

                            <!-- Primeres 2 opción (obligatoria) -->
                            <div class="input-group mb-2">
                                <input type="text" name="options[]" class="form-control" placeholder="Opción 1" required>
                            </div>

                            <div class="input-group mb-2">
                                <input type="text" name="options[]" class="form-control" placeholder="Opción 2" required>
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
            </div>
        </div>
    </div>
</div>

<!-- Script para agregar/eliminar opciones -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('options-container');
        const addButton = document.querySelector('.add-option');

        addButton.addEventListener('click', function () {
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2';

            newInputGroup.innerHTML = `
                <input type="text" name="options[]" class="form-control" placeholder="Nueva opción" required>
                <button type="button" class="btn btn-danger remove-option">−</button>
            `;

            container.appendChild(newInputGroup);
        });

        // Eliminar opción
        container.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-option')) {
                e.target.parentElement.remove();
            }
        });
    });
</script>

@endsection