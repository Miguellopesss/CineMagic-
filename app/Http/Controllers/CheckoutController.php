<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Configuration; // Modelo de configuração para obter preços e descontos
use App\Models\Ticket;
use App\Services\Payment;
use App\Models\Purchase;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage; // Importe a classe Storage aqui
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseConfirmationEmail;
use App\Models\Customer;

class CheckoutController extends Controller
{
    public function show()
{
    // Aqui você pode pré-preencher os dados do cliente se estiver autenticado
    $user = auth()->user();
    $customer=Customer::where('id',$user->id)->first();

    // Obter preços e descontos da configuração
    $configuration = Configuration::first(); // Obtenha a primeira configuração disponível

    // Obtenha o carrinho da sessão
    $cart = session('cart', []);

    // Verifica se a configuração foi encontrada
    if (!$configuration) {
        return back()->with('error', 'Configuração não encontrada.');
    }

    // Atribui os valores corretos
    $ticketPrice = $configuration->ticket_price;
    $discountRate = $configuration->registered_customer_ticket_discount;

    // Calcule o preço total com desconto se aplicável
    $totalPrice = array_reduce($cart, function ($sum, $item) use ($ticketPrice, $discountRate, $user) {
        $price = $ticketPrice;
        if ($user) {
            $price = ($price - $discountRate);
        }
        return $sum + $price;
    }, 0);


    return view('checkout.show', [
        'user'=> $user,
        'customer' => $customer,
        'ticketPrice' => $ticketPrice,
        'discountRate' => $discountRate,
        'totalPrice' => $totalPrice,
        'cart' => $cart,
    ]);
}

public function confirm(Request $request)
{

    // Inicialização dos valores
    $customer = auth()->user();
    $cart = session('cart', []);
    $configuration = Configuration::first();
    $ticketPrice = $configuration->ticket_price;
    $discountRate = $configuration->registered_customer_ticket_discount;

    // Calcule o preço total com desconto se aplicável
    $totalPrice = array_reduce($cart, function ($sum, $item) use ($ticketPrice, $discountRate, $customer) {
        $price = $ticketPrice;
        if ($customer) {
            $price = ($price - $discountRate);
        }
        return $sum + $price;
    }, 0);

    // Simulação de pagamento
    $paymentSuccessful = false;
    switch ($request->payment_type) {
        case 'VISA':

            $paymentSuccessful = Payment::payWithVisa($request->payment_reference, $request->ccv);
            break;
        case 'PAYPAL':
            $paymentSuccessful = Payment::payWithPaypal($request->payment_reference);
            break;
        case 'MBWAY':
            $paymentSuccessful = Payment::payWithMBway($request->payment_reference);
            break;
    }


    if ($paymentSuccessful) {

        // Se o pagamento for bem-sucedido, finalize a compra e armazene no banco de dados
        $purchase = new Purchase();
        $purchase->customer_id = $customer ? $customer->id : null;
        $purchase->date = now();
        $purchase->total_price = $totalPrice;
        $purchase->customer_name = $request->name;
        $purchase->customer_email = $request->email;
        $purchase->nif = $request->nif;

        $purchase->payment_type = $request->payment_type;
        $purchase->payment_ref = $request->payment_reference;
        $purchase->receipt_pdf_filename = ''; // Você pode gerar e atribuir o nome do arquivo PDF do recibo aqui se necessário
        $purchase->save();

        // Criar tickets para cada assento no carrinho
        $ticketsArray = [];
        foreach ($cart as $item) {
                $ticket = new Ticket();
                $ticket->screening_id = $item['screening_id'];
                $ticket->seat_id = $item['seat_id'];
                $ticket->purchase_id = $purchase->id;
                $ticket->price = $customer ? $configuration->ticket_price-$discountRate : $configuration->ticket_price;
                $ticket->qrcode_url=' ';

                $ticket->status= 'valid';
                $ticket->save();
                $ticket->qrcode_url=url('/tickets/' . "$ticket->id");
                $ticket->save();
                $ticketsArray[] = $ticket;

                 // Gerar o Código QR
            $result = Builder::create()
            ->writer(new PngWriter())
            ->data($ticket->qrcode_url)
            ->size(200)
            ->margin(10)
            ->build();

        // Salvar o código QR no sistema de arquivos
        $qrCodePath = storage_path('app/public/qrcodes/ticket_' . $ticket->id . '.png');
        $result->saveToFile($qrCodePath);

        }

        // Gerar PDF
        $pdf = Pdf::loadView('pdf.ticket_receipt', [
            'purchase' => $purchase,
            'ticketsArray' => $ticketsArray
        ]);

        $pdfFilename = 'receipt_' . $purchase->id . '.pdf';
        $pdfPath = storage_path('app/public/receipts/' . $pdfFilename);
        $pdf->save($pdfPath);
        // Atualizar o campo receipt_pdf_filename com o nome do arquivo PDF gerado
        $purchase->receipt_pdf_filename = $pdfFilename;

        $purchase->save();

        //Mail::to($request->email)->send(new PurchaseConfirmationEmail($purchase, $ticketsArray));


        // Limpe o carrinho de compras após a conclusão da compra
        session()->forget('cart');
        $successMessage="Compra confirmada com sucesso!";


        return view('checkout.confirm', [
            'purchase' => $purchase,
            'ticketsArray' => $ticketsArray,
            'alert-type' => 'success', // Defina o tipo de alerta como sucesso
            'alert-msg' => $successMessage // Defina a mensagem de sucesso
        ]);
    } else {
        // Se o pagamento falhar, redirecione de volta com uma mensagem de erro
        return back()
        ->with('alert-type', 'danger')
        ->with('alert-msg', 'O pagamento falhou. Tente novamente.');
    }
}
public function downloadPDF(Purchase $purchase)
    {
        $pdfPath = storage_path('app/public/receipts/' . $purchase->receipt_pdf_filename);

        // Verifica se o arquivo existe
        if (!Storage::exists('public/receipts/' . $purchase->receipt_pdf_filename)) {
            abort(404, 'O arquivo PDF não foi encontrado.');
        }

        // Realiza o download do arquivo PDF
        return response()->download($pdfPath);
    }

}

