@extends('layouts.main')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 overflow-hidden sm:rounded-lg text-neutral-900 dark:text-neutral-50">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Administradores</h1>
                <x-button
                    href="{{ route('admins.create') }}"
                    text="Criar Administrador"
                    type="success"/>
            </div>
            <div class="flex gap-6 mb-6 items-start">
                <form method="GET" action="{{ route('admins.index') }}" class="flex gap-6">
                    <x-field.input name="nome" label="Nome" showLabel="true" width="lg" placeholder="Nome"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('nome')" />
                        <x-field.input name="mail" label="Email" showLabel="true" width="lg" placeholder="Nome"
                        :readonly="$readonly || ($mode == 'show')" :value="request()->get('mail')" />
                    <x-button element="submit" type="dark" text="Filtrar" class="mt-auto"/>
                </form>
            </div>
            <div class="font-base text-sm text-neutral-700 dark:text-neutral-300">
                <x-admins.table :admins="$allAdmins"
                    :showView="true"
                    :showEdit="true"
                    :showDelete="true"
                    />
            </div>
            <div class="mt-4">
                {{ $allAdmins->links() }}
            </div>
        </div>
    </div>
@endsection
