<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Ticket; // Importe o modelo Ticket se ainda não o fez
use App\Models\Screening;
use App\Models\Seat;
use App\Models\Configuration;
class CartController extends Controller
{
    public function show(): View
{
    // Recupera os itens do carrinho da sessão
    $cart = session('cart', []);

    // Retorna a view com os dados do carrinho e o total calculado
    return view('cart.show', compact('cart'));
}



public function addToCart(Request $request): RedirectResponse
{
    // Obtém os IDs de assento do pedido
    $seatIds = $request->input('seats', []);

    // Obtém o ID da sessão de filme
    $sessionId = $request->input('screening_id');

    // Verifica se a sessão está dentro do prazo permitido
    $screening = Screening::with(['movies', 'theaters'])->find($sessionId);
    if (!$screening) {
        return back()->with('error', 'Sessão não encontrada.');
    }

    $currentTime = now();
    $screeningDateTime = new \DateTime($screening->date . ' ' . $screening->start_time);
    $allowedTime = $screeningDateTime->sub(new \DateInterval('PT5M'));

    if ($currentTime > $allowedTime) {
        return back()->with('error', 'Não é possível adicionar ingressos para esta sessão.');
    }

    // Inicializa o carrinho a partir da sessão
    $cart = session('cart', []);
    $configuration = Configuration::first();

    // Para cada assento selecionado
    foreach ($seatIds as $seatId) {
        // Verifica se o (seat_id, session_id) já está no carrinho
        $isReserved = collect($cart)->contains(function ($item) use ($seatId, $sessionId) {
            return $item['seat_id'] == $seatId && $item['screening_id'] == $sessionId;
        });

        if (!$isReserved) {
            // Obtém informações adicionais sobre o assento
            $seat = Seat::find($seatId);

            // Adiciona o novo item ao carrinho
            $cart[] = [
                'seat_id' => $seatId,
                'seat_row' => $seat->row,  // Adiciona a linha do assento
                'seat_number' => $seat->seat_number,  // Adiciona o número do assento
                'sceening_date'=> $screening->date,
                'screening_id' => $sessionId,
                'movie_title' => $screening->movies->title,
                'theater_name' => $screening->theaters->name,
                'start_time' => $screening->start_time,
                'price' => $configuration->ticket_price,

            ];
        } else {
            // Retorna com uma mensagem de erro se o assento já estiver no carrinho para esta sessão
            return back()->with('error', 'Este lugar já está no seu carrinho para esta sessão.');
        }
    }

    // Atualiza a sessão com o carrinho atualizado
    session(['cart' => $cart]);

    // Redireciona de volta à página anterior com uma mensagem de sucesso
    return back()->with('success', 'Assentos adicionados ao carrinho.');
}


public function destroy(): RedirectResponse
{
    // Limpa o carrinho da sessão
    session()->forget('cart');

    return back()->with('success', 'Carrinho limpo com sucesso.');
}
public function remove(Request $request): RedirectResponse
{
    $seatId = $request->input('seat_id');
    $sessionId = $request->input('screening_id');

    // Recupera os itens do carrinho da sessão
    $cart = session()->get('cart', []);

    // Procura o índice do item no carrinho baseado no seat_id e screening_id
    $index = collect($cart)->search(function ($item) use ($seatId, $sessionId) {
        return $item['seat_id'] == $seatId && $item['screening_id'] == $sessionId;
    });

    // Se encontrou o item, remove-o do array
    if ($index !== false) {
        unset($cart[$index]);
        session()->put('cart', $cart); // Atualiza a sessão com o carrinho modificado
    }

    // Redireciona de volta para a página do carrinho ou outra página desejada
    return redirect()->route('cart.show')->with('success', 'Item removido do carrinho com sucesso.');
}



}
