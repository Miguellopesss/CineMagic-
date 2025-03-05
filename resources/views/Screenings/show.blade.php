@extends('layouts.main')

@section('main')
    <main class="mt-0">
    <div class="flex flex-col space-y-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 text-neutral-900 dark:text-neutral-100">
            <div class="max-full">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Sessão {{ $screening->id }}</h1>
                    <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                        <x-button
                            href="{{ route('screenings.create', ['screening' => $screening]) }}"
                            text="Novo"
                            type="success"/>
                        <x-button
                            href="{{ route('screenings.edit', ['screening' => $screening]) }}"
                            text="Editar"
                            type="info"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden flex items-center mt-10 mx-10 gap-8 text-neutral-900 dark:text-neutral-100">
            <div class="w-1/3 flex flex-col text-center p-4 items-center rounded-lg">
                <h1 class="text-2xl font-extrabold">{{ $movie->title }}</h1>
                <p class="text-lg mt-1 text-neutral-600 dark:text-neutral-300">{{ $movie->genre_code}}</p>
                <p class="mt-6 text-lg text-neutral-600 dark:text-neutral-300">{{ \Carbon\Carbon::parse($screening->date)->locale('pt_PT')->isoFormat('dddd, D [de] MMMM') }}</p>
                <h1 class="text-2xl font-extrabold">{{ \Carbon\Carbon::parse($screening->start_time)->format('H:i') }}h</h1>
                <h1 class="mt-6 text-xl font-extrabold">Teatro {{ $theater_name }}</h1>
            </div>
            <div class="w-2/3 flex flex-col justify-between items-center bg-neutral-600/10 rounded-xl">
                <form method="POST" action="{{ route('cart.add') }}" class="my-6 flex flex-col items-center">
                    @csrf
                    <div class="flex flex-col">
                        <p class="self-center text-neutral-700 dark:text-neutral-400">Ecrã</p>
                        <hr class="border-b-2 border-neutral-700 dark:border-neutral-400 mb-8 w-60 self-center">
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
                    <p id="selected-seats" class="text-neutral-600 dark:text-neutral-300">Selecione um Lugar</p>
                    <input type="hidden" name="screening_id" value="{{ $screening->id }}">
                    <x-button element="submit" type="dark" text="Adicionar ao Carrinho" class="mt-8"/>
                </form>
            </div>
        </div>
    </div>
</main>

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
