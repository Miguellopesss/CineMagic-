@extends('layouts.main')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
<div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-neutral-100 dark:bg-neutral-900">
    <div class="w-full sm:max-w-xl mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                @if (Auth::check() && Auth::user()->type != 'E')
                    <div class="p-4 sm:p-8 sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                            {{-- <div class="flex justify-between items-center mt-12">
                                <h1 class="text-2xl font-extrabold mb-6 text-neutral-900 dark:text-neutral-100 border-b-4 border-yellow-400">{{ __('Payment Information') }}</h1>
                            </div>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                            <form method="POST" action="{{ route('profile.updatePayment') }}" class="mt-6 space-y-6">
                                @csrf
                                <x-field.input name="nif" label="NIF" showLabel="true" width="md"
                                             :readonly="$readonly || ($mode == 'show')" :value="$customer->nif" />
                                <x-field.select name="payment_type" label="Tipo de Pagamento" showLabel="true" width="md"
                                                :readonly="$readonly || ($mode == 'show')" :value="$customer->payment_type"
                                                :options="$payment_types" />
                                <x-field.input name="payment_ref" label="Referência de Pagamento" showLabel="true" width="md"
                                                :readonly="$readonly || ($mode == 'show')" :value="$customer->payment_ref" />
                                <x-button element="submit" text="Guardar" type="error" />
                            </form> --}}
                        </div>
                    </div>
                @endif

                <div class="p-4 sm:p-8 sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
