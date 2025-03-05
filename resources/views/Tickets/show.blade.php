@extends('layouts.main')

@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

@section('main')
<div class="flex flex-col space-y-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 text-neutral-900 dark:text-neutral-100">
        <div class="max-full">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Bilhete "{{ $ticket->id }}"</h1>
            </div>
        </div>
        <div class="mt-6 space-y-4 flex">
            <div class="flex-grow">
                <h1>Lugar <span class="text-xl font-bold">{{ $seat->row }} {{ $seat->seat_number }}</span></h1>
                <h1>Filme <span class="text-xl font-bold">{{ $movie_title }}</span></h1>
                <h1>Teatro <span class="text-xl font-bold">{{ $theater_name }}</span></h1>
                <h1>Data <span class="text-xl font-bold">{{ $screening_date }}, {{ $screening_start_time }}</span></h1>
                <h1>Preço <span class="text-xl font-bold">{{ $ticket->price }}€</span></h1>
                <h1>Id da sessão <span class="text-xl font-bold">{{ $ticket->screening_id }}</span></h1>
                <h1>Cliente <span class="text-xl font-bold">{{ $customer_name }}</span></h1>
                <h1>Email <span class="text-xl font-bold">{{ $customer_email }}</span></h1>
            </div>
            <div class="flex-shrink-0 ml-4">
                <x-field.image
                    name="photo_file"
                    label="Foto"
                    width="md"
                    :readonly="$readonly"
                    deleteTitle="Delete Photo"
                    :deleteAllow="($mode == 'show') && ($customer->imageExists)"
                    deleteForm="form_to_delete_photo"
                    :imageUrl="$user->getPhotoFullUrlAttribute()"
                />
            </div>
        </div>
        <div class="mt-6 space-y-4">
            @if ($ticket->status === 'valid')
            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')
                <x-button element="submit" type="dark" text="Usar bilhete" class="uppercase"/>
            </form>
            @else
                <x-alert type="primary" message="Este bilhete já foi usado."/>
            @endif
        </div>
    </div>
</div>
@endsection
