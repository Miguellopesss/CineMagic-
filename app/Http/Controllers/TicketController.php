<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Screening;
use App\Models\Movie;
use App\Models\Seat;
use App\Models\Theater;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{
    public function index(Request $request) : View
    {
        $query = Ticket::query();

        if ($request->has('screening_id') && !empty($request->get('screening_id'))) {
            $query->where('screening_id', $request->get('screening_id'));
        }

        $allTickets = $query->paginate(10)->appends($request->query());

        return view('tickets.index', compact('allTickets'));
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $ticket->status = 'invalid';
        $ticket->save();

        $url = route('tickets.show', ['ticket' => $ticket]);
        $htmlMessage = "Bilhete <a href='$url'><u>{$ticket->id}</u></a> foi usado com sucesso!";

        return redirect()
            ->route('tickets.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function show(Ticket $ticket): View
    {
        $screening = Screening::findOrFail($ticket->screening_id);

        $screening_date = $screening->date;

        $screening_start_time = $screening->start_time;

        $movie = Movie::findOrFail($screening->movie_id);

        $movie_title = $movie->title;

        $seat = Seat::findOrFail($ticket->seat_id);

        $theater = Theater::findOrFail($seat->theater_id);

        $theater_name = $theater->name;

        $purchase = Purchase::findOrFail($ticket->purchase_id);

        $customer_name = $purchase->customer_name;

        $customer_email = $purchase->customer_email;

	    $customer = Customer::findOrFail($purchase->customer_id);

        if($customer)
        {
            $user = User::findOrFail($customer->id);
        }

        return view('tickets.show', compact('ticket', 'theater_name', 'movie_title', 'screening_date', 'screening_start_time', 'seat', 'customer_name', 'customer_email', 'user'));
    }

    public function userTickets(Request $request)
    {
        // Obter o usuário autenticado
        $user = Auth::user();

        // Filtrar os tickets se houver um screening_id fornecido
        $screeningId = $request->input('screening_id');

        // Consultar os tickets do usuário logado
        $query = Ticket::where('purchase_id', $user->id);

        // Aplicar filtro por screening_id, se fornecido
        if ($screeningId) {
            $query->where('screening_id', $screeningId);
        }

        // Obter todos os tickets com paginação
        $allTickets = $query->paginate(10); // Defina o número desejado de tickets por página

        // Retornar a vista com os dados dos tickets
        return view('tickets.user-tickets', compact('allTickets'));
    }
}
