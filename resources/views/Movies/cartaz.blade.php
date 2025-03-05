@extends('layouts.main')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="my-4 p-6 overflow-hidden shadow-sm sm:rounded-lg text-neutral-900 dark:text-neutral-100">
            <div class="flex gap-6 items-center">
                <a href="{{ route('cartaz') }}" class="text-2xl font-extrabold mb-6">Filmes em Cartaz ({{ $moviesCartazCount }})</a>
                @if (Auth::check() && Auth::user()->type == 'A')
                    <a href="{{ route('filmes') }}" class="text-2xl text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 hover:dark:text-neutral-100 font-extrabold mb-6">Todos os Filmes ({{ $moviesCount }})</a>
                @endif
            </div>
            <div class="flex gap-6 mb-6 items-start">
                <form method="GET" action="{{ route('cartaz') }}" class="flex gap-6">
                    <x-field.select name="genero" label="Género" width="lg" :readonly="$readonly"
                        :options="$genres" :value="request()->get('genero')"/>
                    <x-button element="submit" type="dark" text="Filtrar" class="mt-auto"/>
                </form>
            </div>
            @if($moviesCartazCount > 0)
                <div class="flex flex-wrap -mx-4">
                    @foreach($moviesCartaz as $movie)
                        <x-movies.movie-card :movie="$movie"/>
                    @endforeach
                </div>
            @else
                <x-alert type="primary" message="Não foram encontrados filmes."/>
            @endif
        </div>
    </div>
</main>
@endsection

@section('styles')
<style>
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
</style>
@endsection
