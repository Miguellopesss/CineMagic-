@extends('layouts.main')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 overflow-hidden sm:rounded-lg text-neutral-900 dark:text-neutral-50">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Teatros</h1>
                <x-button
                    href="{{ route('theaters.create') }}"
                    text="Criar Teatro"
                    type="success"/>
            </div>
            <div class="flex gap-6 mb-6 items-start">
                <form method="GET" action="{{ route('theaters.index') }}" class="flex gap-6">
                    <x-field.input name="nome" label="Nome" showLabel="true" width="md" placeholder="Nome"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('nome')" />
                    <x-button element="submit" type="dark" text="Filtrar" class="mt-auto"/>
                </form>
            </div>
            <div class="font-base text-sm text-neutral-700 dark:text-neutral-300">
                <x-theaters.table :theaters="$allTheaters"
                    :showView="true"
                    :showEdit="true"
                    />
            </div>
            <div class="mt-4">
                {{ $allTheaters->links() }}
            </div>
        </div>
    </div>
@endsection
