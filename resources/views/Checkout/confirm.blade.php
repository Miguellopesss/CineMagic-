@extends('layouts.main')

@section('header-title', 'Confirmação de Compra')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full sm:max-w-lg lg:max-w-2xl">
        <h2 class="text-xl mb-4">Detalhes da Compra</h2>

        <div class="mb-4">
            <p class="text-lg">Obrigado por sua compra!</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg">Detalhes do Cliente</h3>
            <p><strong>Nome:</strong> {{ $purchase->customer_name }}</p>
            <p><strong>Email:</strong> {{ $purchase->customer_email }}</p>
            <p><strong>NIF:</strong> {{ $purchase->nif }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg">Detalhes da Compra</h3>
            <p><strong>Total a Pagar:</strong> €{{ number_format($purchase->total_price, 2) }}</p>
            <p><strong>Tipo de Pagamento:</strong> {{ ucfirst($purchase->payment_type) }}</p>
            <p><strong>Referência de Pagamento:</strong> {{ $purchase->payment_ref }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg">Tickets</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lugar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Preço</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($ticketsArray as $ticket)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{$ticket->seats->row}}{{$ticket->seats->seat_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">€{{ number_format($ticket->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($ticket->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('download-pdf', $purchase->id) }}" class="text-indigo-600 hover:text-indigo-800">Baixar Recibo em PDF</a>
            <a href="{{ route('home') }}" class="ml-4 text-indigo-600 hover:text-indigo-800">Voltar para a página inicial</a>
        </div>

    </div>
</div>
@endsection
