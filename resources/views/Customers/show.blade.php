@extends('layouts.main')

@section('main')
<div class="flex flex-col space-y-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 text-neutral-900 dark:text-neutral-100">
        <div class="max-full">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Cliente "{{ $customer->name }}"</h1>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('customers.edit', ['customer' => $customer]) }}"
                        text="Editar"
                        type="info"/>
                </div>
            </div>
        </div>
        <div class="mt-6 space-y-4">
            @include('customers.shared.fields', ['mode' => 'show'])
        </div>
    </div>
</div>
@endsection
