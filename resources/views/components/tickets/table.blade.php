@if($tickets->isEmpty())
    <x-alert type="primary" message="Não foram encontrados bilhetes."/>
@else
<div {{ $attributes }}>
    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-800">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Lugar
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Filme
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Sessão
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Preço
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Teatro
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Estado
                </th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Ação
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-600/10 divide-y divide-neutral-200 dark:divide-neutral-700">
            @foreach ($tickets as $ticket)
                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-200">
                        @php
                            $seat = App\Models\Seat::find($ticket->id);
                        @endphp
                        @if ($seat)
                            {{ $seat->row }} {{ $seat->seat_number }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                        @php
                            $screening = App\Models\Screening::find($ticket->screening_id);
                            $movie = App\Models\Movie::find($screening->movie_id);
                        @endphp
                        @if ($movie)
                            {{ $movie->title }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-neutral-900 dark:text-neutral-200">
                        {{ $ticket->screening_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-neutral-900 dark:text-neutral-200">
                        {{ $ticket->price }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-neutral-900 dark:text-neutral-200">
                        @php
                            $screening = App\Models\Screening::find($ticket->screening_id);
                            $theater = App\Models\Theater::find($screening->theater_id);
                        @endphp
                        @if ($theater)
                            {{ $theater->name }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-neutral-900 dark:text-neutral-200">
                        {{ $ticket->status }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center flex gap-2 justify-center">
                        @php
                            $purchase = App\Models\Purchase::find($ticket->purchase_id);
                        @endphp
                        @if ($ticket->status === 'invalid')
                            Nenhuma
                        @else
                            @if ($ticket->receipt_pdf_filename !== null)
                                <div class="flex justify-end mt-6">
                                    <a href="{{ route('download-pdf', $purchase->id) }}" class="text-indigo-600 hover:text-indigo-800">Baixar Recibo em PDF</a>
                                </div>
                            @endif

                        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400">Invalidar</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
