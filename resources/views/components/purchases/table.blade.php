@if($purchases->isEmpty())
    <x-alert type="primary" message="Não foram encontradas compras."/>
@else
<div {{ $attributes }}>
    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-800">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Data
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Preço Total
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Nome do cliente
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-200 uppercase tracking-wider">
                    Tipo de Pagamento
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-600/10 divide-y divide-neutral-200 dark:divide-neutral-700">
            @foreach ($purchases as $purchase)
                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-200">
                        {{ $purchase->date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                        {{ $purchase->total_price }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                        {{ $purchase->customer_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-neutral-900 dark:text-neutral-200">
                        {{ $purchase->payment_type }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($showView)
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">Ver</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
