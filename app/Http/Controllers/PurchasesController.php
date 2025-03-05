<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PurchasesController extends Controller
{
    public function index(Request $request): View
    {
        // Obter todas as compras (pode ser paginado conforme necessário)
        $purchases = Purchase::paginate(10);

        return view('purchases.index', compact('purchases'));
    }

    public function show($id): View
    {
        try {
            // Encontrar a compra pelo ID
            $purchase = Purchase::findOrFail($id);

            // Obter o cliente associado à compra
            $customer = Customer::findOrFail($purchase->customer_id);

            // Obter os bilhetes associados à compra
            $tickets = Ticket::where('purchase_id', $purchase->id)->get();

            // Preparar os dados para a exibição na view
            $data = [
                'purchase_number' => $purchase->id, // Supondo que o ID da compra seja o número da compra
                'purchase_date' => $purchase->created_at->format('d/m/Y H:i:s'), // Data da compra
                'payment_type' => $purchase->payment_type, // Tipo de pagamento
                'payment_reference' => $purchase->payment_reference, // Referência de pagamento
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_nif' => $customer->nif,
                'total_price' => $purchase->total_price,
                'tickets' => $tickets, // Lista de bilhetes associados
            ];

            // Retornar a view com os dados preparados
            return view('purchases.show', $data);

        } catch (ModelNotFoundException $e) {
            // Tratar caso a compra não seja encontrada
            return redirect()->route('purchases.index')->with('error', 'Compra não encontrada.');
        }
    }
}


