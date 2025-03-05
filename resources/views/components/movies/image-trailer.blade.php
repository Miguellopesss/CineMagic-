<div class="flex justify-start items-top h-screen w-screen z-0 dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100">
    <div class="movie-slide relative w-2/3 h-3/4 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-l from-neutral-900 via-neutral-900 via-5% to-transparent pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-900 via-neutral-900 via-5% to-transparent pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-transparent via-5% to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-neutral-900 via-transparent via-5% to-transparent"></div>
        <img src="{{$movie->getPosterFullUrlAttribute()}}" alt="movie img" class="object-cover w-full h-full">
        @if($movie->trailer_url)
        <a class="z-10 absolute inset-0 flex justify-center items-center hover:cursor-pointer" onclick="showTrailer('{{ $movie->trailer_url }}')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 h-20 w-20 drop-shadow-lg hover:text-neutral-600 dark:hover:text-neutral-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
            </svg>
        </a>
    @endif

    </div>
    <div class="absolute inset-0 flex flex-col justify-center items-center left-[35%] my-16">
        @if($overview)
        <div class="flex justify-center items-center gap-6">
            <div class="max-w-sm">
                <p class="text-md font-light text-neutral-700 dark:text-neutral-300 text-center">{{ $movie->year }}</p>
                <h1 class="text-3xl font-bold text-center">{{ $movie->title }}</h1>
                <p class="text-xl text-neutral-800 dark:text-neutral-200 text-center">{{ $movie->genre_code }}</p>
            </div>
            <img class="w-40 rounded-md" src="{{ $movie->getPosterFullUrlAttribute() }}" alt="{{ $movie->title }}">
        </div>
        @endif
        @if(!$overview)
            <h1 class="text-3xl font-bold text-center">{{ $movie->title }}</h1>
            <p class="text-xl text-neutral-800 dark:text-neutral-200 text-center">{{ $movie->genre_code }}</p>
        @endif
        @if($overview)
            <div class="w-1/2 text-center mt-4">
                <p>{{ $movie->synopsis }}</p>
                @if (Auth::check() && Auth::user()->type == 'A')
                <div class="flex gap-4 w-full justify-center mt-4">
                    <x-button
                        href="{{ route('movies.create', ['movie' => $movie]) }}"
                        text="Novo"
                        type="success"/>
                    <x-button
                        href="{{ route('movies.edit', ['movie' => $movie]) }}"
                        text="Editar"
                        type="info"/>
                </div>
                @endif
            </div>
        @endif
        @if($button)
            <a class="z-10 px-6 py-2 mt-10 text-neutral-100 dark:text-neutral-900 bg-neutral-900 hover:bg-neutral-800 dark:bg-neutral-100 hover:dark:bg-neutral-300 rounded-full" href="{{ route('movies.show',  $movie->id) }}">Ver Sessões</a>
        @endif
    </div>
</div>
<script>
    function showTrailer(trailerUrl) {
        window.open(trailerUrl, "_blank", "width=800,height=600");
    }
</script>
