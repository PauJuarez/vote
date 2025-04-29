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
<div class="row">
    <div class="col-12">
        <h2 class="text-white">CRUD de Tareas</h2>
        <a href="{{ route('votations.create') }}" class="btn btn-primary">Crear Votacio</a>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success mt-2">
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @endif  

    <div class="col-12 mt-4">
        <table class="table table-bordered text-white">
            <thead>
                <tr class="text-secondary">
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha inicio</th>
                    <th>Fecha cierre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($votations as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->title }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->end_date }}</td>
                        <td>
                            <!-- Solo muestro el botón de voto si está autenticado -->
                            @auth
                                <form action="{{ route('votes.like', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        @if ($item->votes()->where('user_id', Auth::id())->exists())
                                            👍 {{ $item->votes()->count() }} (Ya te gusta)
                                        @else
                                            👍 {{ $item->votes()->count() }} (Me gusta)
                                        @endif
                                    </button>
                                </form>
                            @else
                                <!-- Si no está autenticado, solo muestro la cantidad de votos -->
                                <span class="text-white">👍 {{ $item->votes()->count() }} votos</span>
                            @endauth
                
                            <!-- Botones de editar/eliminar siempre visibles o protegidos también si quieres -->
                            <a href="{{ route('votations.edit', $item->id) }}" class="btn btn-warning">Editar</a>
                
                            <form action="{{ route('votations.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $votations->links() }}
    </div>
</div>
@endsection
