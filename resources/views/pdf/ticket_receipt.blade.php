<!-- resources/views/pdf/ticket_receipt.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Recibo de Compra</title>
</head>
<body>
    <h1>Recibo de Compra</h1>
    <p><strong>Nome do Cliente:</strong> {{ $purchase->customer_name }}</p>
    <p><strong>Email do Cliente:</strong> {{ $purchase->customer_email }}</p>
    <p><strong>Data:</strong> {{ $purchase->date }}</p>
    <p><strong>Total Pago:</strong> {{ $purchase->total_price }}</p>

    <h2>Tickets</h2>
    <ul>
        @foreach($ticketsArray as $ticket)
            <li>
                <p><strong>Lugar:</strong> {{$ticket->seats->row}}{{$ticket->seats->seat_number }}</p>
                {{--<p><strong>Teatro:</strong> {{ $ticket->screening->theater->name }}</p>
                <p><strong>Filme:</strong> {{ $ticket->screening->movie->title }}</p>
                <p><strong>Data e Hora:</strong> {{ $ticket->screening->date_time }}</p>
                <p><strong>Assento:</strong> {{ $ticket->seat->name }}</p>
                @if ($customer)
                    <p><strong>Nome do Cliente:</strong> {{ $customer->name }}</p>
                    <p><strong>Email do Cliente:</strong> {{ $customer->email }}</p>
                    <p><strong>Foto do Cliente:</strong> <img src="{{ $customer->avatar_url }}" alt="Avatar"></p>
                @endif--}}
                <p><strong>Preço:</strong> {{ $ticket->price }}</p>
                <p><strong>Status:</strong> {{ $ticket->status }}</p>
                <p><strong>QR Code:<br></strong> <img src="{{ asset('storage/qrcodes/ticket_' . $ticket->id . '.png') }}" alt="QR Code"></p>
            </li>
        @endforeach
    </ul>
</body>
</html>
