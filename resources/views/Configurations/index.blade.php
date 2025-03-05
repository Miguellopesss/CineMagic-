@extends('layouts.main')

@php
    $mode = $mode == 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 overflow-hidden sm:rounded-lg text-neutral-900 dark:text-neutral-50">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Configurações</h1>
            </div>
            <div class="font-base text-sm text-neutral-700 dark:text-neutral-300">
                <x-configurations.table :configurations="$configurations"
                    :showEdit="true"
                    />
            </div>
            <div class="mt-4">
                {{ $configurations->links() }}
            </div>
        </div>
    </div>
@endsection
