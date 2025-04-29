@extends('layouts.base')

@section('content')
<header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<div class="container mt-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="text-white">CRUD de Votaciones</h2>
            <a href="{{ route('votations.create') }}" class="btn btn-primary">Crear Votación</a>
        </div>

        @if (Session::get('success'))
            <div class="alert alert-success mt-2">
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif  

        <div class="col-12">
            <table class="table table-bordered text-white">
                <thead>
                    <tr class="text-secondary">
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Opciones</th>
                        <th>Fecha inicio</th>
                        <th>Fecha cierre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($votations as $votation)
                        <tr>
                            <td class="fw-bold">{{ $votation->title }}</td>
                            <td>{{ $votation->description }}</td>
                            
                            <!-- Opciones -->
                            <td>
                                @if($votation->options->isNotEmpty())
                                    <ul class="list-group list-group-flush">
                                        @foreach ($votation->options as $option)
                                            <li class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                                                {{ $option->option_text }}
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-white">
                                                        👍 {{ $option->votes()->count() }} votos
                                                    </span>
                                                
                                                    @auth
                                                        <form action="{{ route('votes.like-option', $option->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                @if ($option->votes->where('user_id', auth()->id())->isNotEmpty())
                                                                    (Quitar voto)
                                                                @else
                                                                    (Votar)
                                                                @endif
                                                            </button>
                                                        </form>
                                                    @endauth
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Sin opciones</span>
                                @endif
                            </td>

                            <td>{{ $votation->start_date }}</td>
                            <td>{{ $votation->end_date }}</td>

                            <!-- Acciones -->
                            <td>
                                <a href="{{ route('votations.edit', $votation->id) }}" class="btn btn-warning btn-sm mb-2 w-100">Editar</a>

                                <form action="{{ route('votations.destroy', $votation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $votations->links() }}
        </div>
    </div>
</div>

@endsection