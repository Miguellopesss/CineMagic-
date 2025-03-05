@if($screenings->isEmpty())
    <x-alert type="primary" message="Não foram encontradas sessões."/>
@else
<table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
    <thead class="bg-neutral-50 dark:bg-neutral-800">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Id
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Filme
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Teatro
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Data
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Hora Início
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Ações
            </th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-neutral-600/10 divide-y divide-neutral-200 dark:divide-neutral-700">
        @foreach($screenings as $screening)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-200">
                    {{ $screening->id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-200">
                    @php
                        $movie = App\Models\Movie::find($screening->movie_id);
                    @endphp
                    @if ($movie)
                        {{ $movie->title }}
                    @else
                        Movie Not Found
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    @php
                        $theater = App\Models\Theater::find($screening->theater_id);
                    @endphp
                    @if ($theater)
                        {{ $theater->name }}
                    @else
                        Theater Not Found
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $screening->date }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $screening->start_time }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @if($showView)
                        <a href="{{ route('screenings.show', $screening->id) }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">Show</a>
                    @endif
                    @if($showEdit)
                        <a href="{{ route('screenings.edit', $screening->id) }}" class="ml-4 text-yellow-600 hover:text-yellow-700 dark:text-yellow-400">Edit</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
