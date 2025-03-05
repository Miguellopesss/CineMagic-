@extends('layouts.main')

@section('main')
<main class="mt-0">
    <div id="movies-container">
        @foreach($moviesCartaz as $index => $movie)
            <div class="movie" data-index="{{ $index }}" style="display: none;">
                <x-movies.image-trailer :movie="$movie" :button="true"/>
            </div>
        @endforeach
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden text-neutral-900 dark:text-neutral-100">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Filmes em Cartaz</h1>
                <a href="{{ Route('cartaz')}}" class="underline hover:text-neutral-600 dark:hover:text-neutral-300">Ver todos os filmes em cartaz</a>
            </div>
            <div class="flex flex-wrap -mx-4 justify-between mb-40">
                @foreach($moviesCartaz->take(5) as $movie)
                    <x-movies.movie-card :movie="$movie" />
                @endforeach
            </div>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Géneros</h1>
                <a href="{{ Route('filmes')}}" class="underline hover:text-neutral-600 dark:hover:text-neutral-300">Filtrar filmes por género</a>
            </div>
            <div class="flex gap-12 justify-between mb-20">
                <div class="w-1/2 h-[500px] overflow-hidden rounded-xl">
                    @foreach($genres->slice(1, 1) as $genre)
                    <a href="{{ route('cartaz', ['genero' => $genre->code]) }}">
                        <div class="relative">
                            <h1 class="text-2xl absolute top-4 left-4 z-10 text-white">{{ $genre->name }}</h1>
                            @if($genre->movies->isNotEmpty())
                                <img src="{{ $genre->movies->first()->getPosterFullUrlAttribute() }}" alt="movie img" class="object-cover w-full h-full">
                                <div class="absolute inset-0 bg-neutral-900 opacity-50 hover:opacity-0 transition duration-500 ease-in-out rounded-xl"></div>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="w-1/2 h-[500px] flex flex-col gap-12 overflow-hidden">
                    @foreach($genres->slice(2, 2) as $key => $genre)
                        @if($key > 0)
                            <div class="w-full h-1/2 overflow-hidden relative">
                                <a href="{{ route('cartaz', ['genero' => $genre->code]) }}">
                                    <h1 class="text-2xl absolute top-4 left-4 z-10 text-white">{{ $genre->name }}</h1>
                                    @if($genre->movies->isNotEmpty())
                                        <img src="{{ $genre->movies->first()->getPosterFullUrlAttribute() }}" alt="movie img" class="object-cover w-full h-full rounded-xl">
                                        <div class="absolute inset-0 bg-neutral-900 opacity-50 hover:opacity-0 transition duration-500 ease-in-out rounded-xl"></div>
                                    @endif
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</main>
<style>
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const movies = document.querySelectorAll('.movie');
        let currentIndex = 0;

        function showNextMovie() {
            movies[currentIndex].style.display = 'none';
            currentIndex = (currentIndex + 1) % movies.length;
            movies[currentIndex].style.display = 'block';
        }

        if (movies.length > 0) {
            movies[0].style.display = 'block';
            setInterval(showNextMovie, 5000);
        }
    });
</script>
@endsection

