@extends('layouts.main')

@section('main')
    <main class="mt-8">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="my-4 p-6 overflow-hidden shadow-sm sm:rounded-lg text-neutral-900 dark:text-neutral-100">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Resultados da Pesquisa</h1>
                </div>
                @if($movies->isEmpty())
                <x-alert type="primary" message="Não foram encontrados filmes em cartaz com esse nome."/>
                @else
                    <div class="flex flex-wrap -mx-4">
                        @foreach($movies as $movie)
                            <x-movies.movie-card :movie="$movie"/>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
