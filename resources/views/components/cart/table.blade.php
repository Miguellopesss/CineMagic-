<div {{ $attributes}}>
    <table class="table-auto border-collapse">
        <thead>
            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Assento</th>
                <th class="px-2 py-2 text-left">Data</th>
                <th class="px-2 py-2 text-left">Filme</th>
                <th class="px-2 py-2 text-right">Sessão</th>
                <th class="px-2 py-2 text-right">Preço</th>
                <th class="px-2 py-2 text-right">Teatro</th>
                <th class="px-2 py-2 text-center">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $item)
                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                    <td class="px-2 py-2">
                        @if (isset($item['seat_row']) && isset($item['seat_number']))
                            {{ $item['seat_row'] }}{{ $item['seat_number'] }}
                        @endif
                    </td>
                    <td class="px-2 py-2">{{ $item['sceening_date'] }}</td>
                    <td class="px-2 py-2">{{ $item['movie_title'] }}</td>
                    <td class="px-2 py-2 text-right">{{ $item['start_time'] }}</td>
                    <td class="px-2 py-2 text-right">{{ $item['price'] }}</td>
                    <td class="px-2 py-2 text-right">{{ $item['theater_name'] }}</td>
                    <td class="px-2 py-2 text-center">
                        <form action="{{ route('cart.remove', ['seat_id' => $item['seat_id'], 'screening_id' => $item['screening_id']]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <x-table.icon-minus class="px-0.5"/>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr class="border-t-2 border-t-gray-400 dark:border-t-gray-500 bg-gray-200 dark:bg-gray-700">
                <td colspan="4" class="px-2 py-2 text-right font-bold">Total a pagar</td>
                @php
                     $total = 0;

                    foreach ($cart as $item) {
                        $total += $item['price'];
                    }
                @endphp
                <td class="px-2 py-2 text-right font-bold">{{$total}}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</div>
