@extends('layouts.main')

@section('main')
    <div class="my-4 p-6 overflow-hidden sm:rounded-lg text-neutral-900 dark:text-neutral-50">
        <div class="flex items-center justify-between gap-4 mb-4">
            <h1 class="text-2xl font-extrabold mb-6 border-b-4 border-yellow-400">Detalhes da Compra #{{ $purchase_number }}</h1>
        </div>
        <div class="mb-6">
            <p><strong>Data da Compra:</strong> {{ $purchase_date }}</p>
            <p><strong>Tipo de Pagamento:</strong> {{ $payment_type }}</p>
            <p><strong>Referência de Pagamento:</strong> {{ $payment_reference }}</p>
            <p><strong>Nome do Cliente:</strong> {{ $customer_name }}</p>
            <p><strong>Email do Cliente:</strong> {{ $customer_email }}</p>
            <p><strong>NIF do Cliente:</strong> {{ $customer_nif }}</p>
            <p><strong>Preço Total:</strong> {{ $total_price }}</p>
        </div>
        <div class="font-base text-sm text-neutral-700 dark:text-neutral-300">
            <h2 class="text-lg font-bold mb-4">Bilhetes Associados</h2>
            @if ($tickets->isEmpty())
                <x-alert type="info" message="Não foram encontrados bilhetes associados a esta compra."/>
            @else
                <ul class="list-disc list-inside">
                    @foreach ($tickets as $ticket)
                        <li>
                            <strong>Lugar:</strong> {{ $ticket->seat->row }} {{ $ticket->seat->seat_number }},
                            <strong>Filme:</strong> {{ $ticket->screening->movie->title }},
                            <strong>Teatro:</strong> {{ $ticket->seat->theater->name }},
                            <strong>Sessão:</strong> {{ $ticket->screening->date }} às {{ $ticket->screening->start_time }},
                            <strong>Preço:</strong> {{ $ticket->price }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection

