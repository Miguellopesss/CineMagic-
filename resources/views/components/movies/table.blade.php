@if($movies->isEmpty())
    <x-alert type="primary" message="Não foram encontrados filmes."/>
@else
<table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
    <thead class="bg-neutral-50 dark:bg-neutral-800">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Id
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Titulo
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Género
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Ano
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Ações
            </th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-neutral-600/10 divide-y divide-neutral-200 dark:divide-neutral-700">
        @foreach($movies as $movie)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-200">
                    {{ $movie->id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-200">
                    {{ $movie->title }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    @php
                        $genre = App\Models\Genre::find($movie->genre_code);
                    @endphp
                    @if ($genre)
                        {{ $genre->name }}
                    @else
                        Genre Not Found
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $movie->year }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @if($showView)
                        <a href="{{ route('movies.show', $movie->id) }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">Show</a>
                    @endif
                    @if($showEdit)
                        <a href="{{ route('movies.edit', $movie->id) }}" class="ml-4 text-yellow-600 hover:text-yellow-700 dark:text-yellow-400">Edit</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
