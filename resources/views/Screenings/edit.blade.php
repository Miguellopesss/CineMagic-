@extends('layouts.main')

@section('main')
    <div class="flex flex-col space-y-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 text-neutral-900 dark:text-neutral-100">
            <div class="max-full">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Editar a Sessão {{ $screening->id }}</h1>
                    <div class="flex flex-wrap justify-start items-center gap-4 mb-4">
                        <x-button
                            href="{{ route('screenings.create', ['screening' => $screening]) }}"
                            text="Novo"
                            type="success"/>
                        <x-button
                            href="{{ route('screenings.show', ['screening' => $screening]) }}"
                            text="Ver"
                            type="info"/>
                        <form method="POST" action="{{ route('screenings.destroy', $screening->id) }}">
                            @csrf
                            @method('DELETE')
                            <x-button
                                element="submit"
                                text="Apagar"
                                type="danger"/>
                        </form>
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 mb-6">
                    Clicar no botão "Guardar" para armazenar a informação.
                </p>
                <div class="flex gap-8">
                    <div class="w-1/2">
                        <form method="POST" action="{{ route('screenings.update', ['screening' => $screening]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mt-6 space-y-4">
                                @include('screenings.shared.fields', ['mode' => 'edit'])
                            </div>
                            <div class="flex mt-6">
                                <x-button element="submit" type="dark" text="Guardar" class="uppercase"/>
                                <x-button element="a" type="light" text="Cancelar" class="uppercase ms-4"
                                            href="{{ url()->full() }}"/>
                            </div>
                        </form>
                    </div>
                    <div class="w-2/3 flex flex-col justify-between items-center bg-neutral-600/10 rounded-xl">
                        <form method="POST" action="{{ route('cart.add') }}" class="my-6 flex flex-col items-center">
                            @csrf
                            <div class="flex flex-col">
                                <p class="self-center text-neutral-400">Ecrã</p>
                                <hr class="border-b-2 border-neutral-400 mb-8 w-60 self-center">
                                @foreach($seats->groupBy('row') as $row => $seatsInRow)
                                    <div class="flex self-center">
                                        @foreach($seatsInRow as $seat)
                                            <label>
                                                @php
                                                    $isReserved = $tickets->contains('seat_id', $seat->id);
                                                @endphp
                                                <input type="checkbox" name="seats[]" value="{{ $seat->id }}" class="m-1 p-3 rounded-sm border-0 focus:ring-yellow-400 {{ $isReserved ? 'bg-red-500 opacity-70' : 'hover:bg-neutral-300 hover:cursor-pointer' }}" onchange="updateSelectedSeats()"
                                                    @if($isReserved) disabled @endif>
                                                <span id="seat-{{ $seat->id }}" class="hidden">{{ $seat->row }}{{ $seat->seat_number }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <p class="mt-4 font-bold">Lugares Selecionados</p>
                            <p id="selected-seats" class="text-neutral-300">Selecione um Lugar</p>
                            <input type="hidden" name="screening_id" value="{{ $screening->id }}">
                            <x-button element="submit" type="dark" text="Adicionar ao Carrinho" class="mt-8"/>
                        </form>
                    </div>
                </div>
            </div>

    <script>
        function updateSelectedSeats() {
            var selectedSeats = [];
            var checkboxes = document.querySelectorAll('input[name="seats[]"]:checked');
            checkboxes.forEach(function(checkbox) {
                var seatId = checkbox.value;
                var seatInfo = document.getElementById('seat-' + seatId);
                var seatDescription = seatInfo.textContent.trim();
                selectedSeats.push(seatDescription);
            });

            var selectedSeatsText = selectedSeats.join(', ');
            if (selectedSeatsText === '') {
                selectedSeatsText = 'Selecione um Lugar';
            }

            document.getElementById('selected-seats').textContent = selectedSeatsText;
        }
    </script>

    <style>
        input[type=checkbox]:checked {
            color: #facc15; /* change the color when checked */
        }
    </style>
@endsection
