<a href="{{ route('movies.show', [$movie->id]) }}" class="w-1/6 my-4 mx-4 min-w-44">
    <div class="relative group">
        <img class="w-full rounded-md" src="{{ $movie->getPosterFullUrlAttribute() }}" alt="{{ $movie->title }}">
        <div class="absolute inset-0 rounded-md bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 flex flex-col justify-center items-center text-white transition-opacity duration-300">
            @if($ano)
                <p class="text-sm text-neutral-200">{{ $movie->year }}</p>
            @endif
            <h1 class="text-lg font-bold text-center">{{ $movie->title }}</h1>
            <p class="text-sm text-neutral-200">{{ $movie->genre_code }}</p>
        </div>
    </div>
</a>
