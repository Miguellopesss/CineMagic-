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
                <a href="{{ route('cartaz') }}" class="text-2xl text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 hover:dark:text-neutral-100 font-extrabold mb-6">Filmes em Cartaz ({{ $moviesCartazCount }})</a>
                <a href="{{ route('filmes') }}" class="text-2xl font-extrabold mb-6">Todos os Filmes ({{ $moviesCount }})</a>
            </div>
            <div class="flex items-center justify-between gap-4 mb-4">
                <div class="flex gap-4">
                    <a href="{{ route('movies.index') }}" class="flex gap-2 text-lg text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 hover:dark:text-neutral-100 font-extrabold mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                      </svg>
                      Vista Tabela</a>
                    <a href="{{ route('filmes') }}" class="flex gap-2 text-lg font-extrabold mb-6">
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
            <div class="flex flex-col gap-6 mb-6 items-start">
                <form method="GET" action="{{ route('filmes') }}" class="flex gap-6">
                    <x-field.input name="title" label="Titulo" showLabel="true" width="lg" placeholder="Titulo  "
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('title')" />
                    <x-field.select name="genre_code" label="Género" width="md" :readonly="$readonly"
                        :options="$genres" :value="request()->get('genre_code')"/>
                    <x-field.input name="year" label="Ano" showLabel="true" width="md" placeholder="Ano"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('year')" />
                    <x-button element="submit" type="dark" text="Filtrar" class="mt-auto"/>
                </form>
            </div>
            @if($moviesCount > 0)
                @foreach($movies as $genre => $genreMovies)
                <div class="genre-row mb-8">
                    @php
                        $genre_name = \App\Models\Genre::where('code', $genre)->first()->name;
                    @endphp
                    <h2 class="text-xl font-bold mb-4">{{ $genre_name }}</h2>
                    <div class="relative flex items-center">
                        <button type="button" class="prev-btn absolute top-1/2 left-0 transform -translate-y-1/2 text-gray-600 p-1 rounded-full hover:bg-gray-300 hover:bg-opacity-50 z-10" onclick="scrollCarousel('.{{ $genre }}-carousel', -400)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600 hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="sr-only">Anterior</span>
                        </button>
                        <div class="carousel {{ $genre }}-carousel flex flex-no-wrap ml-2 mr-2 overflow-x-auto">
                            @foreach($genreMovies as $movie)
                                <x-movies.movie-card :movie="$movie" :ano="true"/>
                            @endforeach
                        </div>
                        <button type="button" class="next-btn absolute top-1/2 right-0 transform -translate-y-1/2 text-gray-600 p-1 rounded-full hover:bg-gray-300 hover:bg-opacity-50 z-10" onclick="scrollCarousel('.{{ $genre }}-carousel', 400)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600 hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="sr-only">Próximo</span>
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <x-alert type="primary" message="Não foram encontrados filmes."/>
            @endif
        </div>
    </div>
</main>

<style>
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
    .carousel {
        display: flex;
        overflow-x: scroll;
        scroll-behavior: smooth;
    }
    .carousel::-webkit-scrollbar {
        display: none;
    }
    .carousel > * {
        flex: 0 0 auto;
        margin-right: 1rem;
    }
</style>

<script>
    function scrollCarousel(carouselClass, distance) {
        const carousel = document.querySelector(carouselClass);
        carousel.scrollLeft += distance;
    }
</script>
@endsection
