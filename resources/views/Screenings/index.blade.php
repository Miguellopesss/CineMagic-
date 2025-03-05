@extends('layouts.main')

@section('header-title', 'Lista de Sessões')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 overflow-hidden sm:rounded-lg text-neutral-900 dark:text-neutral-50">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Sessões</h1>
                <x-button
                    href="{{ route('screenings.create') }}"
                    text="Criar Sessão"
                    type="success"/>
            </div>
            <div class="flex gap-6 mb-6 items-start">
                <form method="GET" action="{{ route('screenings.index') }}" class="flex gap-6">
                    <x-field.input name="movie" label="Filme" showLabel="true" width="full" placeholder="Filme"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('movie')" />
                        <x-field.input name="theater" label="Teatro" showLabel="true" width="full" placeholder="Teatro"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('theater')" />
                        <x-field.input name="date" label="Data" showLabel="true" width="full" placeholder="Data"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('date')" />
                        <x-field.input name="start_time" label="Hora Início" showLabel="true" width="full" placeholder="Hora Início"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('start_time')" />
                    <x-button element="submit" type="dark" text="Filtrar" class="mt-auto"/>
                </form>
            </div>
            <div class="font-base text-sm text-neutral-700 dark:text-neutral-300">
                <x-screenings.table :screenings="$allScreenings"
                    :showView="true"
                    :showEdit="true"
                    />
            </div>
            <div class="mt-4">
                {{ $allScreenings->links() }}
            </div>
        </div>
    </div>
@endsection
