@extends('layouts.main')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 overflow-hidden sm:rounded-lg text-neutral-900 dark:text-neutral-50">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Bilhetes</h1>
            </div>
            <div class="flex gap-6 mb-6 items-start flex-col">
                <form method="GET" action="{{ route('tickets.index') }}" class="flex gap-6">
                    <x-field.input name="screening_id" label="Id da Sessão" showLabel="true" width="md"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('screening_id')" />
                    <x-button element="submit" type="dark" text="Filtrar" class="mt-auto"/>
                </form>
                <a href="{{ route('screenings.index')}}" class="text-neutral-600 dark:text-neutral-400 hover:text-neutral-800 hover:dark:text-neutral-200">Ver tabela das sessões</a>
            </div>
            <div class="font-base text-sm text-neutral-700 dark:text-neutral-300">
                <x-tickets.table :tickets="$allTickets"
                    :showView="true"
                    :showEdit="true"
                    />
            </div>
            <div class="mt-4">
                {{ $allTickets->links() }}
            </div>
        </div>
    </div>
@endsection
