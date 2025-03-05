@extends('layouts.main')

@section('main')
<div class="flex flex-col space-y-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 text-neutral-900 dark:text-neutral-100">
        <div class="max-full">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Editar "{{ $movie->title }}"</h1>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('movies.create', ['movie' => $movie]) }}"
                        text="Novo"
                        type="success"/>
                    <x-button
                        href="{{ route('movies.show', ['movie' => $movie]) }}"
                        text="Ver"
                        type="info"/>
                    <form method="POST" action="{{ route('movies.destroy', ['movie' => $movie]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Apagar"
                            type="danger"/>
                    </form>
                </div>
            </div>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                Clicar no botão "Guardar" para armazenar a informação.
            </p>
            <form method="POST" action="{{ route('movies.update', ['movie' => $movie]) }}"
                    enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mt-6 space-y-4">
                    @include('movies.shared.fields', ['mode' => 'edit'])
                </div>
                <div class="flex mt-6">
                    <x-button element="submit" type="dark" text="Guardar" class="uppercase"/>
                    <x-button element="a" type="light" text="Cancelar" class="uppercase ms-4"
                                href="{{ url()->full() }}"/>
                </div>
            </form>
        </div>
    </div>
</div>
<form class="hidden" id="form_to_delete_image"
    method="POST" action="{{ route('movies.destroyPoster', ['movie' => $movie]) }}">
    @csrf
    @method('DELETE')
</form>
@endsection

