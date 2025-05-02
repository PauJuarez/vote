@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white">
                <div class="card-header">
                    <h3 class="card-title mb-0">Editar Tarea</h3>
                    <a href="{{ route('home') }}" class="btn btn-primary">Volver</a>

                </div>
                <div class="card-body">

                    <!-- Mensaje de error -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Por las chancas de mi madre!</strong> Algo fue mal..<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('votations.update', $votation->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Indica que es una actualización -->

                        <!-- Título -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Título:</label>
                            <input type="text" name="title" id="title" class="form-control"
                                   value="{{ old('title', $votation->title) }}" required>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción:</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $votation->description) }}</textarea>
                        </div>

                        <!-- Fechas -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Fecha de Inicio:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                       value="{{ old('start_date', $votation->start_date) }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Fecha de Fin:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                       value="{{ old('end_date', $votation->end_date) }}" required>
                            </div>
                        </div>

                        <!-- Opciones -->
                        <div id="options-container">
                            <label class="form-label">Opciones:</label>

                            @foreach ($votation->options as $index => $option)
                                <div class="input-group mb-2 option-row">
                                    <input type="text" name="options[]" class="form-control"
                                           value="{{ old('options.' . $index, $option->option_text) }}" required>
                                    <!-- Eliminar opción solo si es a partir de la tercera opción -->
                                    @if ($index >= 2)
                                        <button type="button" class="btn btn-danger remove-option">-</button>
                                    @endif
                                    <!-- Botón de agregar opción solo para la segunda opción -->
                                    @if ($index === 1)
                                        <button type="button" class="btn btn-success add-option">+</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <!-- Botón submit -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Actualizar Votación</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar una opción al formulario
        document.querySelector('.add-option').addEventListener('click', function() {
            const container = document.getElementById('options-container');
            const newOption = document.createElement('div');
            newOption.classList.add('input-group', 'mb-2', 'option-row');
            newOption.innerHTML = `
                <input type="text" name="options[]" class="form-control" required>
                <button type="button" class="btn btn-danger remove-option">-</button>
            `;
            container.appendChild(newOption);
        });

        // Eliminar una opción del formulario
        document.querySelectorAll('.remove-option').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.option-row').remove();
            });
        });
    });
</script>

@endsection
