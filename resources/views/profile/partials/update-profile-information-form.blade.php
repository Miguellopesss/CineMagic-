@php
    $user = Auth::user();
    $customer = App\Models\Customer::where('id', $user->id)->first();
    $payment_types = ['MBWAY', 'VISA', 'PAYPAL'];
@endphp

<section>
    <header>
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-extrabold mb-6 text-neutral-900 dark:text-neutral-100 border-b-4 border-yellow-400">{{ __('Profile Information') }}</h1>
        </div>

        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-neutral-800 dark:text-neutral-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 dark:focus:ring-offset-neutral-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="pb-6">
            <x-field.image
                name="photo_file"
                label="Foto"
                width="md"
                :readonly="$readonly"
                deleteTitle="Eliminar Foto"
                :deleteAllow="($mode == 'edit') && ($customer->imageExists ?? false)"
                deleteForm="form_to_delete_photo"
                :imageUrl="$user->getPhotoFullUrlAttribute()"
            />
        </div>

        <div class="flex justify-between items-center mt-12">
            <h1 class="text-2xl font-extrabold mb-6 text-neutral-900 dark:text-neutral-100 border-b-4 border-yellow-400">{{ __('Payment Information') }}</h1>
        </div>
        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
            <div class="p-4 sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

        @if ($user->type != 'C')
            <x-field.input name="nif" label="NIF" showLabel="true" width="md"
                            :readonly="$readonly || ($mode == 'show')" :value="$customer->nif ?: ''" />
            <x-field.select name="payment_type" label="Tipo de Pagamento" showLabel="true" width="md"
                            :readonly="$readonly || ($mode == 'show')" :value="$customer->payment_type ?: ''"
                            :options="$payment_types" />
            <x-field.input name="payment_ref" label="Referência de Pagamento" showLabel="true" width="md"
                            :readonly="$readonly || ($mode == 'show')" :value="$customer->payment_ref ?: ''" />
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-neutral-600 dark:text-neutral-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
