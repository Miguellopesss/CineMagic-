@extends('layouts.main')

@section('main')
    <x-movies.image-trailer :movie="$movie" :overview="true" />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden text-neutral-900 dark:text-neutral-100">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Sessões Disponíveis</h1>
            </div>
            @if ($isInCartaz)
                @if ($screeningsByDate->isEmpty())
                    <p class="text-gray-500">Não há sessões disponíveis para este filme nas próximas duas semanas.</p>
                @else
                    <div class="dates-container flex overflow-x-auto mb-4 space-x-2">
                        @foreach ($screeningsByDate as $date => $theaters)
                            <button class="date-button bg-transparent px-4 py-2 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-800 hover:text-white transition" data-date="{{ $date }}">
                                {{ \Carbon\Carbon::parse($date)->format('d/m') }}
                            </button>
                        @endforeach
                    </div>

                    <div id="screenings-container">
                        @foreach ($screeningsByDate as $date => $theaters)
                            <div class="screenings-day" data-date="{{ $date }}" style="display: none;">
                                @foreach ($theaters as $theaterData)
                                    <div class="theater-group mb-4 ml-4">
                                        <h3 class="text-xl font-semibold mb-4">Teatro {{ $theaterData['theater_name'] }}</h3>
                                        <div class="screening-times flex space-x-4">
                                            @foreach ($theaterData['screenings'] as $screening)
                                                <x-button element="a" type="dark" :text="\Carbon\Carbon::parse($screening->start_time)->format('H:i')" :href="route('screenings.show', ['screening' => $screening])"/>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr class="border-t border-gray-700 my-4">
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <p class="mb-10">Este filme não tem sessões disponíveis neste momento :(</p>
                {{-- <x-alert type="primary" message="Este filme não tem sessões disponíveis."/> --}}
            @endif
        </div>
        <div class="h-10">

        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateButtons = document.querySelectorAll('.date-button');
        const screeningsContainer = document.getElementById('screenings-container');
        const screeningsDayDivs = document.querySelectorAll('.screenings-day');

        if (dateButtons.length > 0) {
            // Marcar a primeira data como selecionada e mostrar suas sessões
            dateButtons[0].classList.add('bg-blue-500', 'text-white', 'selected');
            const firstDate = dateButtons[0].getAttribute('data-date');
            document.querySelector(`.screenings-day[data-date="${firstDate}"]`).style.display = 'block';
        }

        dateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const selectedDate = this.getAttribute('data-date');

                // Remover classes de 'selecionado' de todos os botões e esconder todas as sessões
                dateButtons.forEach(btn => btn.classList.remove('bg-blue-500', 'text-white', 'selected'));
                screeningsDayDivs.forEach(div => div.style.display = 'none');

                // Adicionar classes de 'selecionado' ao botão clicado e mostrar as sessões correspondentes
                this.classList.add('bg-blue-500', 'text-white', 'selected');
                document.querySelector(`.screenings-day[data-date="${selectedDate}"]`).style.display = 'block';
            });
        });
    });
</script>

<style>
    .dates-container {
        white-space: nowrap;
    }
    .date-button.selected {
        color: rgb(250 204 21);
        font-weight: 700;
    }
    .screenings-day {
        display: none;
    }
</style>
@endsection
