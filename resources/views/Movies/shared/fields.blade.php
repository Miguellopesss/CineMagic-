@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Titulo" width="lg" :readonly="$readonly"
                        value="{{ old('title', $movie->title) }}"/>
        <x-field.select name="genre_code" label="Género" width="lg" :readonly="$readonly"
                        :options="$genres" value="{{ old('genre_code', $movie->genre_code) }}"/>
        <x-field.input name="year" label="Ano" width="lg" :readonly="$readonly"
                        value="{{ old('year', $movie->year) }}"/>
        <x-field.text-area name="synopsis" label="Sinopse" :readonly="$readonly"
                        value="{{ old('synopsis', $movie->synopsis) }}"/>
        <x-field.input name="trailer_url" label="URL do Trailer" :readonly="$readonly"
                        value="{{ old('trailer_url', $movie->trailer_url) }}"/>
    </div>
    <div class="pb-6">
        <x-field.image
            name="poster_filename"
            label="Imagem do Filme"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Image"
            :deleteAllow="true"
            deleteForm="form_to_delete_image"
            :imageUrl="$movie->getPosterFullUrlAttribute()"/>
    </div>
</div>
