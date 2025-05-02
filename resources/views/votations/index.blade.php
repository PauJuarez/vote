@extends('layouts.base')

@section('content')
<header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    @endif
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            <a
            href="{{ url('/dashboard') }}"
            class="inline-block mt-4 px-6 py-2.5 bg-gradient-to-r from-gray-800 to-gray-900 dark:from-gray-700 dark:to-black text-white font-medium text-sm leading-normal rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 border border-gray-700 dark:border-gray-500"
        >
            Go to Dashboard
        </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block mt-4 px-6 py-2.5 bg-gradient-to-r from-gray-800 to-gray-900 dark:from-gray-700 dark:to-black text-white font-medium text-sm leading-normal rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 border border-gray-700 dark:border-gray-500"
                    >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-block mt-4 px-6 py-2.5 bg-gradient-to-r from-gray-800 to-gray-900 dark:from-gray-700 dark:to-black text-white font-medium text-sm leading-normal rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 border border-gray-700 dark:border-gray-500"
                        >
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
            <div class="text-center mt-8">
                <h1 class="text-4xl font-bold text-white drop-shadow-lg">Votaciones</h1>
                @auth
                    <p class="text-green-500">Participa y haz tu voto, {{ Auth::user()->name }} 🎉</p>
                @else
                    <p class="text-red-500">Si quieres participar loguea.</p>
                @endauth
            </div>
            @if (Gate::allows('access-admin'))
                <a href="{{ route('votations.create') }}" class="btn btn-primary">Crear Votación</a>
            @endif
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
                        @if (Gate::allows('access-admin'))
                            <th>Acción</th>
                        @endif
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
                            @if (Gate::allows('access-admin'))

                                <td>
                                    <a href="{{ route('votations.edit', $votation->id) }}" class="btn btn-warning btn-sm mb-2 w-100">Editar</a>

                                    <form action="{{ route('votations.destroy', $votation->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100">Eliminar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $votations->links() }}
        </div>
    </div>
</div>

@endsection