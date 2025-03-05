@extends('layouts.main')

@section('main')
<div class="flex flex-col space-y-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 text-neutral-900 dark:text-neutral-100">
        <div class="max-full">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Teatro "{{ $theater->name }}"</h1>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4 lg:mb-0">
                    <x-button
                        href="{{ route('theaters.create', ['theater' => $theater]) }}"
                        text="Novo"
                        type="success"/>
                    <x-button
                        href="{{ route('theaters.edit', ['theater' => $theater]) }}"
                        text="Editar"
                        type="info"/>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row lg:space-x-8 mt-4">
                <div class="flex-1">
                    <div class="mt-6 space-y-4">
                        @include('theaters.shared.fields', ['mode' => 'show'])
                    </div>
                </div>
                <div class="w-full lg:w-2/3 bg-neutral-600/10 rounded-xl p-4"> 
                    <div class="my-6 flex flex-col items-center">
                        <p class="self-center text-neutral-400">Ecrã</p>
                        <hr class="border-b-2 border-neutral-400 mb-8 w-60 self-center">
                        @foreach($seats->groupBy('row') as $row => $seatsInRow)
                            <div class="flex self-center">
                                @foreach($seatsInRow as $seat)
                                    <label>
                                        <input type="checkbox" name="seats[]" value="{{ $seat->id }}" class="m-1 p-3 rounded-sm border-0 focus:ring-yellow-400">
                                        <span id="seat-{{ $seat->id }}" class="hidden">{{ $seat->row }}{{ $seat->seat_number }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
