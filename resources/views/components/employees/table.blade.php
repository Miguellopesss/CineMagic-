@if($employees->isEmpty())
    <x-alert type="primary" message="Não foram encontrados empregados."/>
@else
<table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
    <thead class="bg-neutral-50 dark:bg-neutral-800">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Foto
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Nome
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Email
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Bloqueado
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                Ações
            </th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-neutral-600/10 divide-y divide-neutral-200 dark:divide-neutral-700">
        @foreach($employees as $employee)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-200">
                    <img src="{{ $employee->getPhotoFullUrlAttribute() }}" alt="employee Photo" class="h-10 w-10 rounded-full object-cover">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $employee->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $employee->email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $employee->blocked ? 'Sim' : 'Não'}}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @if($showView)
                        <a href="{{ route('employees.show', $employee->id) }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">Show</a>
                    @endif
                    @if($showEdit)
                        <a href="{{ route('employees.edit', $employee->id) }}" class="ml-4 text-yellow-600 hover:text-yellow-700 dark:text-yellow-400">Edit</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
