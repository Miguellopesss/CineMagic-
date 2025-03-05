@if($genres->isEmpty())
    <x-alert type="primary" message="Não foram encontrados géneros."/>
@else
<table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
    <thead class="bg-neutral-50 dark:bg-neutral-800">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Código
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Nome
            </th>
            <th scope="col" class="pl-10 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Ações
            </th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-neutral-600/10 divide-y divide-neutral-200 dark:divide-neutral-700">
        @foreach($genres as $genre)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-200">
                    {{ $genre->code }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $genre->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @if($showView)
                        <a href="{{ route('genres.show', $genre->code) }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">Ver</a>
                    @endif
                    @if($showEdit)
                        <a href="{{ route('genres.edit', $genre->code) }}" class="ml-4 text-yellow-600 hover:text-yellow-700 dark:text-yellow-400">Editar</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
