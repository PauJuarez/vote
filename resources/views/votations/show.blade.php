@if (Gate::allows('access-admin'))
<a href="{{ route('votations.create') }}" class="btn btn-primary">Crear Votación</a>
@endif