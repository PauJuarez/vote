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
    {{-- <form action="{{ route('votacions.update', $votation->id) }}" method="POST"> --}}
        <form action="" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    <strong>Título:</strong>
                    <input type="text" name="title" class="form-control" placeholder="Título de la votación">
                </div>
            </div>

            <div class="col-md-12 mt-2">
                <div class="form-group">
                    <strong>Descripción:</strong>
                    <textarea class="form-control" name="description" style="height: 150px" placeholder="Descripción..."></textarea>
                </div>
            </div>

            <div class="col-md-6 mt-2">
                <div class="form-group">
                    <strong>Fecha de inicio:</strong>
                    <input type="date" name="start_date" class="form-control">
                </div>
            </div>

            <div class="col-md-6 mt-2">
                <div class="form-group">
                    <strong>Fecha de fin:</strong>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    <strong>id_user:</strong>
                    <input type="text" name="user_id" class="form-control" placeholder="id">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection