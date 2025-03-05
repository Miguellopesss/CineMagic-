@extends('layouts.main')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 overflow-hidden sm:rounded-lg text-neutral-900 dark:text-neutral-50">
            <div class="flex gap-6 items-center">
                <a href="{{ route('cartaz') }}" class="text-2xl text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 hover:dark:text-neutral-100 font-extrabold mb-6">Filmes em Cartaz ({{ $moviesCartazCount }})</a>
                <a href="{{ route('filmes') }}" class="text-2xl font-extrabold mb-6">Todos os Filmes ({{ $moviesCount }})</a>
            </div>
            <div class="flex items-center justify-between gap-4 mb-4">
                <div class="flex gap-4">
                    <a href="{{ route('movies.index') }}" class="flex gap-2 text-lg font-extrabold mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                      </svg>
                      Vista Tabela</a>
                    <a href="{{ route('filmes') }}" class="flex gap-2 text-lg text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 hover:dark:text-neutral-100 font-extrabold mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                      </svg>
                      Vista Card</a>
                </div>
                <x-button
                    href="{{ route('movies.create') }}"
                    text="Criar Filme"
                    type="success"/>
            </div>
            <div class="flex gap-6 mb-6 items-start max-w-7xl">
                <form method="GET" action="{{ route('movies.index') }}" class="flex gap-6">
                    <x-field.input name="title" label="Titulo" showLabel="true" width="lg" placeholder="Titulo  "
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('title')" />
                    <x-field.select name="genre_code" label="Género" width="md" :readonly="$readonly"
                        :options="$genres" :value="request()->get('genre_code')"/>
                    <x-field.input name="year" label="Ano" showLabel="true" width="md" placeholder="Ano"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('year')" />
                    <x-button element="submit" type="dark" text="Filtrar" class="mt-auto"/>
                </form>
            </div>
            <div class="font-base text-sm text-neutral-700 dark:text-neutral-300">
                <x-movies.table :movies="$allMovies"
                    :showView="true"
                    :showEdit="true"
                    />
            </div>
            <div class="mt-4">
                {{ $allMovies->links() }}
            </div>
        </div>
    </div>
@endsection
