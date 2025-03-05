<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Compra - Detalhes dos Tickets</title>
</head>
<body>
    <h2>Obrigado por sua compra!</h2>

    <p>Aqui estão os detalhes da sua compra:</p>

    <p><strong>Nome:</strong> {{ $purchase->customer_name }}</p>
    <p><strong>Email:</strong> {{ $purchase->customer_email }}</p>
    <p><strong>Total Pago:</strong> €{{ number_format($purchase->total_price, 2) }}</p>


    <h3>Detalhes dos Tickets:</h3>
    <ul>
        @foreach ($ticketsArray as $ticket)
            <li>Lugar: {{$ticket->seats->row}}{{$ticket->seats->seat_number }}</li>
            <li>Preço do Ticket: €{{ number_format($ticket->price, 2) }}</li>
            <li>Status do Ticket: {{ ucfirst($ticket->status) }}</li>
            <br>
        @endforeach
    </ul>

    <p>Obrigado por escolher nossos serviços!</p>

    <!-- Adicione o link para download do PDF -->
    <p>Para fazer o download do recibo da compra, <a href="{{ url(route('download-pdf', ['purchase' => $purchase->id])) }}">clique aqui</a>.</p>


</body>
</html>
