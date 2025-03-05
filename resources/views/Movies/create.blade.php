@extends('layouts.main')

@section('main')
<div class="flex flex-col space-y-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 text-neutral-900 dark:text-neutral-100">
        <div class="max-full">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Criar novo Filme</h1>
            </div>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 mb-6">
                Clicar no botão "Guardar" para armazenar a informação.
            </p>
            <form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mt-6 space-y-4">
                    @include('movies.shared.fields', ['mode' => 'create', 'movie' => new \App\Models\Movie(), 'genres' => $genres])
                </div>
                <div class="flex mt-6">
                    <x-button element="submit" type="dark" text="Guardar novo Filme" class="uppercase"/>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
