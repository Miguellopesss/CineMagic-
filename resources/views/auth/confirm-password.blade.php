@extends('layouts.main')

@section('main')
    <div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-neutral-100 dark:bg-neutral-900">
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-extrabold mb-6 text-neutral-900 dark:text-neutral-100 border-b-4 border-yellow-400">{{ __('Confirm Password') }}</h1>
            </div>

            <div class="mb-4 text-sm text-neutral-600 dark:text-neutral-400">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
