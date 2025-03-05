@extends('layouts.main')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 overflow-hidden sm:rounded-lg text-neutral-900 dark:text-neutral-50">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Empregados</h1>
                <x-button
                    href="{{ route('employees.create') }}"
                    text="Criar Empregado"
                    type="success"/>
            </div>
            <div class="flex gap-6 mb-6 items-start">
                <form method="GET" action="{{ route('employees.index') }}" class="flex gap-6">
                    <x-field.input name="nome" label="Nome" showLabel="true" width="lg" placeholder="Nome"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('nome')" />
                        <x-field.input name="mail" label="Email" showLabel="true" width="lg" placeholder="Nome"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('mail')" />
                    <x-button element="submit" type="dark" text="Filtrar" class="mt-auto"/>
                </form>
            </div>
            <div class="font-base text-sm text-neutral-700 dark:text-neutral-300">
                <x-employees.table :employees="$allEmployees"
                    :showView="true"
                    :showEdit="true"
                    />
            </div>
            <div class="mt-4">
                {{ $allEmployees->links() }}
            </div>
        </div>
    </div>
@endsection
